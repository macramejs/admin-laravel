<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Http\Indexes\{{ page }}Index;
use {{ namespace }}\Http\Resources\{{ page }}CollectionResource;
use {{ namespace }}\Http\Resources\{{ page }}Resource;
use {{ namespace }}\Ui\Page;
use App\Models\{{ file_model }};
use App\Models\{{ page }}Collection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class {{ page }}Controller
{
    /**
     * {{ page }} index page.
     *
     * @param  Request $request
     * @param  {{ model }}Index $index
     * @return {{ model }}Index
     */
    public function items(Request $request, {{ page }}Index $index)
    {
        return $index->items(
            request: $request, 
            query: {{ file_model }}::query(), 
            resource: {{ page }}Resource::class
        );
    }

    /**
     * Show a single file.
     *
     * @param Request $request
     * @param {{ model }} $file
     * @return {{ page }}Resource
     */
    public function item(Request $request, {{ file_model }} $file)
    {
        return new {{ page }}Resource($file);
    }

    /**
     * Show the {{ page }} index.
     *
     * @param  Page $page
     * @return Page
     */
    public function index(Page $page, $mimeType = null)
    {
        $collections = {{ page }}Collection::withCount('files')->get();

        return $page
            ->page('{{ page }}/Index')
            ->with('collections', {{ page }}CollectionResource::collection($collections));
    }

    /**
     * Destroy multiple files.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        {{ file_model }}::whereIn('id', $request->ids)->delete();

        return redirect()->back();
    }

    /**
     * Upload files.
     *
     * @param Request $request
     * @return void
     */
    public function upload(Request $request)
    {
        collect($request->files->get('files'))
            ->each(function (UploadedFile $file) {
                {{ file_model }}::createFromUploadedFile($file);
            });
    }
}
