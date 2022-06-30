<?php

namespace Admin\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Admin\Http\Resources\MenuResource;
use Admin\Http\Resources\StoredResource;
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

    /**
     * Store a new menu.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $menu = Menu::make([
            'title' => $request->title,
            'type'      => $request->type,
        ]);

        $menu->save();

        return new StoredResource($menu);
    }
}
