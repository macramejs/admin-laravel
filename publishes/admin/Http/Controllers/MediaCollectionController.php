<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\MediaIndex;
use Admin\Http\Resources\MediaCollectionResource;
use Admin\Ui\Page;
use App\Models\File;
use App\Models\MediaCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaCollectionController
{
    /**
     * Ship index page.
     *
     * @param  Page $page
     * @return Page
     */
    public function items(
        Request $request,
        MediaCollection $collection,
        MediaIndex $index
    ) {
        return $index->items($request, $collection->files());
    }

    /**
     * Show the file.
     *
     * @param  Page $page
     * @return Page
     */
    public function show(Page $page, MediaCollection $collection)
    {
        $collections = MediaCollection::withCount('files')->get();

        return $page
            ->page('Media/Index')
            ->with('collection', new MediaCollectionResource($collection))
            ->with('collections', MediaCollectionResource::collection($collections));
    }

    /**
     * Create a new MediaCollection.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        MediaCollection::create([
            'title' => $request->title,
            'key'   => Str::slug($request->title),
        ]);

        return redirect()->back();
    }

    /**
     * Add a list of files to the collection.
     *
     * @param Request $request
     * @param MediaCollection $collection
     * @return RedirectResponse
     */
    public function add(Request $request, MediaCollection $collection)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        File::whereIn('id', $request->ids)->get()
            ->each(function (File $file) use ($collection) {
                if ($collection->isAttachedTo($file)) {
                    return;
                }

                $file->attach($collection);
            });

        return redirect()->back();
    }

    /**
     * Remove a list of files from the collection.
     *
     * @param Request $request
     * @param MediaCollection $collection
     * @return RedirectResponse
     */
    public function remove(Request $request, MediaCollection $collection)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        File::whereIn('id', $request->ids)->get()
            ->each(function (File $file) use ($collection) {
                if (! $collection->isAttachedTo($file)) {
                    return;
                }

                $file->detach($collection);
            });

        return redirect()->back();
    }

    /**
     * Upload files.
     *
     * @param Request $request
     * @param MediaCollection $collection
     * @return void
     */
    public function upload(Request $request, MediaCollection $collection)
    {
        collect($request->files->get('files'))
            ->each(function (UploadedFile $file) use ($collection) {
                $file = File::createFromUploadedFile($file);

                $file->save();

                $file->attach($collection);
            });

        return response()->json();
    }
}
