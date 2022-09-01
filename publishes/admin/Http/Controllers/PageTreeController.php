<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\PageTreeResource;
use Admin\Policies\PageTreePolicy;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class PageTreeController
{
    /**
     * Get the pages tree.
     *
     * @return AnonymousResourceCollection
     */
    public function show(Request $request)
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
