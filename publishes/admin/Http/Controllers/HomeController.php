<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Ui\Page;

/**
 * @module app
 */
class HomeController
{
    /**
     * Show the home page for the admin application.
     *
     * @param  Page $page
     * @return Page
     */
    public function show(Page $page)
    {
        return $page->page('Home/Show');
    }
}
