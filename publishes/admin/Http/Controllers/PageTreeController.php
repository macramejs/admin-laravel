<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\PageIndex;
use Admin\Http\Resources\PageResource;
use Admin\Http\Resources\PageTreeResource;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PageTreeController
{
    /**
     * Get the pages tree.
     *
     * @return AnonymousResourceCollection
     */
    public function show()
    {
        return PageTreeResource::collection(Page::root());
    }

    /**
     * Update the order for of the page tree.
     *
     * @param  Request $request
     * @return void
     */
    public function update(Request $request)
    {
        Page::updateOrder($request->order);

        return response()->noContent();
    }
}
