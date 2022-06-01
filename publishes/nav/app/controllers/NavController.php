<?php

namespace Admin\Http\Controllers;

use Admin\Ui\Page;
use App\Models\NavItem;
use Illuminate\Http\Request;
use App\Models\Types\NavType;
use App\Models\Page as PageModel;
use Illuminate\Http\RedirectResponse;
use Admin\Http\Resources\Options\LinkOption;
use Admin\Http\Resources\LinkOptionResource;
use Admin\Http\Resources\NavItemTreeResource;

class NavController
{
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
     * Show the nav page for the admin application.
     *
     * @param  Page    $page
     * @param  NavType $type
     * @return Page
     */
    public function show(Page $page, NavType $type)
    {
        $linkOptions = $this->linkOptions($type);

        $items = NavItem::whereRoot()
            ->where('type', $type->value)
            ->orderBy('order_column')
            ->get();

        return $page->page('Nav/Show')
            ->with('items', NavItemTreeResource::collection($items))
            ->with('link-options', LinkOptionResource::collection($linkOptions))
            ->with('type', $type->value);
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

    /**
     * Get a list of the selectable link options for the nav item.
     *
     * @param  NavType          $type
     * @return array|Collection
     */
    protected function linkOptions(NavType $type)
    {
        $items = PageModel::get()
            ->map(function (PageModel $page) {
                return LinkOption::fromRoute(
                    title: $page->name,
                    name: $page->getRoute()->getName(),
                );
            });

        return $items;
    }
}
