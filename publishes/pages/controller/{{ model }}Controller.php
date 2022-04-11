<?php

namespace App\Http\Controllers;

use App\Models\{{ model }};
use Inertia\Inertia;
use Illuminate\Http\Request;

class {{ model }}Controller extends Controller
{
    /**
     * Show the page.
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        $page = {{ model }}::fromRequestOrFail($request);

        $page->content->parse();
        $page->attributes->parse();

        return Inertia::render('Pages/Show', [
            'page' => $page
        ]);
    }
}
