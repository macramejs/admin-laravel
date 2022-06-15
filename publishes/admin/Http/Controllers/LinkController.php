<?php

namespace Admin\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Admin\Http\Resources\LinkOptionResource;
use Admin\Http\Resources\Options\LinkOption;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LinkController
{
    /**
     * Get link items.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        $items = Page::get()
            ->map(function (Page $page) {
                return LinkOption::fromRoute(
                    title: $page->name,
                    name: $page->getRoute()->getName(),
                );
            });

        return LinkOptionResource::collection($items);
    }
}
