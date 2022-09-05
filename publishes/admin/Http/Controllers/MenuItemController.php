<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\StoredResource;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            'title'              => 'required|string',
            'link'               => 'nullable|string',
            'is_group'           => 'bool',
            'alternative_layout' => 'bool',
            'cols'               => 'nullable|numeric',
        ]);

        if ($menu->type == 'main') {
            Cache::forget('mainNavigation');
        }
        if ($menu->type == 'footer') {
            Cache::forget('footerNavigation');
        }

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
            'title'              => 'required|string',
            'link'               => 'nullable|string',
            'is_group'           => 'bool',
            'alternative_layout' => 'bool',
            'cols'               => 'nullable|numeric',
        ]);

        if ($menu->type == 'main') {
            Cache::forget('mainNavigation');
        }
        if ($menu->type == 'footer') {
            Cache::forget('footerNavigation');
        }

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
        if ($menu->type == 'main') {
            Cache::forget('mainNavigation');
        }
        if ($menu->type == 'footer') {
            Cache::forget('footerNavigation');
        }

        $menu
            ->items()
            ->where('id', $itemId)
            ->firstOrFail()
            ->delete();
    }
}
