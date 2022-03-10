<?php

namespace App\Http\Controllers;

use App\Models\{{ model }};
use Illuminate\Http\Request;

class {{ model }}Controller
{
    /**
     * Get the site from the given request.
     *
     * @param  Request $request
     * @return {{ model }}
     */
    protected function getSiteFromRequest(Request $request): {{ model }}
    {
        $id = last(explode('.', $request->route()->getName()));

        return {{ model }}::findOrFail($id);
    }

    /**
     * Handle the incomming request.
     *
     * @param  Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $site = $this->getSiteFromRequest($request);

        return $site;
    }
}
