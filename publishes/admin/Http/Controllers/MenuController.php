<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\MenuResource;
use Admin\Http\Resources\StoredResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

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
        $query = Menu::query();

        return MenuResource::collection($query->get());
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
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        $menu = Menu::make($validated);

        $menu->type = Str::slug($request->title);

        $menu->save();

        return new StoredResource($menu);
    }
}
