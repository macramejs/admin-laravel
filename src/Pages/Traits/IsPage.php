<?php

namespace Macrame\CMS\Pages\Traits;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Route;
use Macrame\Tree\Traits\IsTree;

trait IsPage
{
    use IsTree;

    public static function routes()
    {
        try {
            static::where('parent_id', null)
                ->get()
                ->each(function (self $site) {
                    if (! $site->is_live) {
                        return;
                    }

                    Route::get(
                        $site->getFullSlug(),
                        $site->getController()
                    )->name("site.{$site->id}");
                });
        } catch (QueryException $e) {
        }
    }

    public function getRouteAction(): string | Closure
    {
        return $this->controller;
    }

    public function getFullSlug(): string
    {
        if (! $this->parent) {
            return '/'.$this->slug;
        }

        return $this->parent->slug.'/'.$this->slug;
    }
}
