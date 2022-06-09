<?php

namespace App\Http\Controllers;

use App\Models\{{ model }};
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\{{ model }}Resource;

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

        return Inertia::render('Pages/Show', [
            'page' => (new {{ model }}Resource($page))->toArray($request),
        ]);
    }
}
