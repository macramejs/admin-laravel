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
     * Ship index page.
     *
     * @param  Page $page
     * @return Page
     */
    public function files(Request $request, {{ page }}Index $index)
    {
        return $index->items($request, {{ model }}::query(), {{ page }}Resource::class);
    }

    /**
     * Show the index of all file collections.
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

    public function upload(Request $request)
    {
        collect($request->files->get('images'))
            ->each(function (UploadedFile $file) {
                {{ file_model }}::newFromUploadedFile($file)->save();
            });
    }
}
