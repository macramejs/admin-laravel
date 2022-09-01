<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\MenuItemTreeResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

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
        if ($menu->type == 'main') {
            Cache::forget('mainNavigation');
        }
        if ($menu->type == 'footer') {
            Cache::forget('footerNavigation');
        }

        $menu
            ->items()
            ->updateOrder($request->order);
    }
}
