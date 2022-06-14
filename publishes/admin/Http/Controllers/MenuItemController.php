<?php

namespace Admin\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Admin\Http\Resources\MenuItemTreeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuItemController
{
    /**
     * Get menu item tree.
     *
     * @param  Request $request
     * @param  Menu $menu
     * @return AnonymousResourceCollection
     */
    public function tree(Request $request, Menu $menu)
    {
        $tree = $menu
            ->items()
            ->whereRoot()
            ->get();

        return MenuItemTreeResource::collection($tree);
    }

    /**
     * Store a new navigation item.
     *
     * @param  Request  $request
     * @param  Menu     $menu
     * @param  string   $id
     * @return void
     */
    public function update(Request $request, Menu $menu, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'link'  => 'required|string',
        ]);

        $menu
            ->items()
            ->whereKey($id)
            ->firstOrFail()
            ->update($validated);
    }

    /**
     * Store a new navigation item.
     *
     * @param  Request  $request
     * @param  Menu     $menu
     * @param  int|null $parentId
     * @return void
     */
    public function store(Request $request, Menu $menu, $parentId = null)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'link'  => 'required|string',
        ]);

        $parent = null;
        if($parentId) {
            // Checking whether a parent exists for the given menu.
            $parent = $menu->items()->where('id', $parentId)->firstOrFail();
        }

        MenuItem::create(array_merge($validated, [
            'menu_id'   => $menu->id,
            'parent_id' => $parent ? $parent->id : null,
        ]));
    }

    /**
     * Update the order of the navigation tree.
     *
     * @param  Request $request
     * @param  Menu $menu
     * @return void
     */
    public function order(Request $request, Menu $menu)
    {
        $menu
            ->items()
            ->updateOrder($request->order);
    }

    /**
     * Remove an item from the navigation tree.
     *
     * @param Request $request
     * @param Menu $menu
     * @param int $itemId
     * @return void
     */
    public function destroy(Request $request, Menu $menu, $itemId)
    {
        $menu
            ->items()
            ->where('id', $itemId)
            ->firstOrFail()
            ->delete();
    }
}
