<?php

namespace Macrame\Admin\Pages\Traits;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Route;
use Macrame\Tree\Traits\IsTree;

trait IsPage
{
    use IsTree;

    /**
     * Generate the routes for the pages.
     *
     * @param string $controller
     * @return void
     */
    public static function routes($controller)
    {
        try {
            static::where('parent_id', null)
                ->get()
                ->each(function (self $site) use ($controller) {
                    if (! $site->is_live) {
                        return;
                    }

                    Route::get(
                        $site->getFullSlug(),
                        $controller,
                    )->name("site.{$site->id}");
                });
        } catch (QueryException $e) {
        }
    }

    /**
     * Get the route action.
     *
     * @return void
     */
    public function getRouteAction(): string | Closure
    {
        return $this->controller;
    }

    /**
     * Get the full slug of the page.
     *
     * @return string
     */
    public function getFullSlug(): string
    {
        if (! $this->parent) {
            return '/'.$this->slug;
        }

        return $this->parent->getFullSlug().'/'.$this->slug;
    }
}
