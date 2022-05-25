<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Ui\Page;
use Illuminate\Http\Request;

class SettingController
{

    /**
     * Show the ship index page for the admin application.
     *
     * @return Page
     */
    public function index(Request $request, Page $page): Page
    {
        return $page
            ->page('Settings/Index');
    }
}
