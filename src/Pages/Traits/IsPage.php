<?php

namespace Macrame\Admin\Pages\Traits;

use Closure;
use Illuminate\Http\Request;
use Macrame\Tree\Traits\IsTree;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;

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
     * Get the page model from the given request.
     *
     * @param Request $request
     * @return self
     */
    public static function fromRequestOrFail(Request $request)
    {
        $id = last(explode('.', $request->route()->getName()));

        if (!$id) {
            abort(404);
        }

        return static::findOrFail($id);
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
