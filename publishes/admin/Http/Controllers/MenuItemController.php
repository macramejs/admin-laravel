<?php

namespace Admin\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Admin\Http\Resources\StoredResource;
use Admin\Http\Resources\MenuItemTreeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuItemController
{
    /**
     * Updates a new navigation item.
     *
     * @param  Request $request
     * @param  Menu    $menu
     * @param  string  $id
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
        if ($parentId) {
            // Checking whether a parent exists for the given menu.
            $parent = $menu->items()->where('id', $parentId)->firstOrFail();
        }

        $item = MenuItem::create(array_merge($validated, [
            'menu_id'   => $menu->id,
            'parent_id' => $parent ? $parent->id : null,
        ]));

        return new StoredResource($item);
    }
    
    /**
     * Remove an item from the navigation tree.
     *
     * @param  Request $request
     * @param  Menu    $menu
     * @param  int     $itemId
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
