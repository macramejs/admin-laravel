<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Http\Resources\NavItemTreeResource;
use {{ namespace }}\Ui\Page;
use App\Models\NavItem;
use App\Models\Types\NavType;
use Illuminate\Http\Request;

class NavController
{
    /**
     * Show the nav page for the admin application.
     *
     * @param  Page    $page
     * @param  NavType $type
     * @return Page
     */
    public function show(Page $page, NavType $type)
    {
        $items = NavItem::whereRoot()
            ->where('type', $type)
            ->orderBy('order_column')
            ->get();

        return $page->page('Nav/Show')
            ->with('items', NavItemTreeResource::collection($items))
            ->with('type', $type->value);
    }

    public function store(Request $request, NavType $type, NavItem $item = null)
    {
        NavItem::create([
            'title'     => $request->title,
            'type'      => $type->value,
            'parent_id' => $item ? $item->id : null,
        ]);

        return redirect()->back();
    }

    public function order(Request $request, NavType $type)
    {
        NavItem::updateOrder($type, $request->order);

        return redirect()->back();
    }
}
