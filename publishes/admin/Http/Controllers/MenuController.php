<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController
{
    /**
     * Gets a list of navigation types.
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        return MenuResource::collection(Menu::all());
    }

    /**
     * Gets a list of navigation types.
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function item(Request $request, Menu $menu)
    {
        return new MenuResource($menu);
    }
}
