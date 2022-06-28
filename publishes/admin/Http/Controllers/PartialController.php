<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\PartialResource;
use App\Models\Partial;
use Illuminate\Http\Request;

class PartialController
{
    /**
     * Display the specified resource.
     *
     * @param  \Admin\Ui\Page            $page
     * @param  \App\Models\Partial       $partial
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $template)
    {
        $partial = Partial::firstOrCreate([
            'template' => $template,
            'name'     => ucfirst($template),
        ]);

        return PartialResource::make($partial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @param  \App\Models\Partial        $partial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partial $partial)
    {
        $validated = $request->validate([
            'attributes' => 'array',
            // 'name'       => 'sometimes|string',
        ]);

        $partial->update($validated);

        return PartialResource::make($partial);
    }
}
