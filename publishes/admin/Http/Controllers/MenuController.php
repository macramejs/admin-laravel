<?php

namespace Admin\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Admin\Http\Resources\MenuResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController
{
    /**
     * Gets a list of navigation types.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        return MenuResource::collection(Menu::all());
    }
}
