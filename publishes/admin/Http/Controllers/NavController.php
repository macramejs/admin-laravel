<?php

namespace Admin\Http\Controllers;

use Admin\Ui\Page;
use App\Models\NavItem;
use Illuminate\Http\Request;
use App\Models\Types\NavType;
use Illuminate\Http\RedirectResponse;
use Admin\Http\Resources\NavTypeResource;
use Admin\Http\Resources\NavItemTreeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NavController
{
    /**
     * Gets a list of navigation types.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function types(Request $request)
    {
        return NavTypeResource::collection(NavType::cases());
    }

    /**
     * Show a index page for all available navigations.
     *
     * @return Page
     */
    public function index(Request $request, Page $page)
    {
        return $page->page('Nav/Index');
    }

    /**
     * Get navigation tree.
     *
     * @param  NavType $type
     * @return AnonymousResourceCollection
     */
    public function tree(NavType $type)
    {
        $items = NavItem::whereRoot()
            ->where('type', $type->value)
            ->orderBy('order_column')
            ->get();

        return NavItemTreeResource::collection($items);
    }

    /**
     * Store a new navigation item.
     *
     * @param  Request          $request
     * @param  NavType          $type
     * @param  string           $id
     * @return RedirectResponse
     */
    public function update(Request $request, NavType $type, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'link'  => 'required|string',
        ]);

        NavItem::where('type', $type->value)
            ->whereKey($id)
            ->update($validated);

        return redirect()->back();
    }

    /**
     * Store a new navigation item.
     *
     * @param  Request          $request
     * @param  NavType          $type
     * @param  NavItem|null     $item
     * @return RedirectResponse
     */
    public function store(Request $request, NavType $type, NavItem $item = null)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'link'  => 'required|string',
        ]);

        NavItem::create(array_merge($validated, [
            'type'      => $type->value,
            'parent_id' => $item ? $item->id : null,
        ]));

        return redirect()->back();
    }

    /**
     * Update the order of the navigation tree.
     *
     * @param  Request          $request
     * @param  NavType          $type
     * @return RedirectResponse
     */
    public function order(Request $request, NavType $type)
    {
        NavItem::updateOrder($request->order);

        return redirect()->back();
    }

    /**
     * Remove an item from the navigation tree.
     *
     * @param  Request          $request
     * @param  NavItem          $item
     * @return RedirectResponse
     */
    public function destroy(Request $request, NavType $type, NavItem $item)
    {
        $item->delete();

        return redirect()->back();
    }
}
