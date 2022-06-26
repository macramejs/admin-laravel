<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\MenuItemTreeResource;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuItemTreeController
{
    /**
     * Get menu item-tree.
     *
     * @param  Request                     $request
     * @param  Menu                        $menu
     * @return AnonymousResourceCollection
     */
    public function show(Request $request, Menu $menu)
    {
        $tree = $menu
            ->items()
            ->whereRoot()
            ->get();

        return MenuItemTreeResource::collection($tree);
    }

    /**
     * Update the order of the menu item-tree.
     *
     * @param  Request $request
     * @param  Menu    $menu
     * @return void
     */
    public function update(Request $request, Menu $menu)
    {
        $menu
            ->items()
            ->updateOrder($request->order);
    }
}
