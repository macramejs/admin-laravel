<?php

namespace Admin\Http\Controllers\Traits;

use App\Models\Types\NavType;
use App\Models\Page as PageModel;
use Admin\Http\Resources\Options\LinkOption;

trait PageLinks
{
    /**
     * Get a list of the selectable link options.
     *
     * @param  NavType          $type
     * @return array|Collection
     */
    protected function linkOptions()
    {
        $items = PageModel::get()
            ->map(function (PageModel $page) {
                return LinkOption::fromRoute(
                    title: $page->name,
                    name: $page->getRoute()->getName(),
                );
            });

        return $items;
    }
}
