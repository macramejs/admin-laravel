<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Http\Indexes\{{ page }}Index;
use {{ namespace }}\Http\Resources\{{ page }}CollectionResource;
use {{ namespace }}\Ui\Page;
use App\Models\{{ model }};
use App\Models\{{ page }}Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class {{ page }}CollectionController
{
    /**
     * Ship index page.
     *
     * @param  Page $page
     * @return Page
     */
    public function items(
        Request $request,
        {{ page }}Collection $collection,
        {{ page }}Index $index
    ) {
        return $index->items($request, $collection->files());
    }

    /**
     * Show the file.
     *
     * @param  Page $page
     * @return Page
     */
    public function show(Page $page, {{ page }}Collection $collection)
    {
        $collections = {{ page }}Collection::withCount('files')->get();

        return $page
            ->page('{{ page }}/Index')
            ->with('collection', new {{ page }}CollectionResource($collection))
            ->with('collections', {{ page }}CollectionResource::collection($collections));
    }

    public function store(Request $request)
    {
        {{ page }}Collection::create([
            'title' => $request->title,
            'key'   => Str::slug($request->title),
        ]);

        return redirect()->back();
    }

    public function upload(Request $request, {{ page }}Collection $collection)
    {
        collect($request->files->get('images'))
            ->each(function (UploadedFile $file) use ($collection) {
                $file = {{ model }}::newFromUploadedFile($file);

                $file->save();

                $file->attach($collection);
            });
    }
}
