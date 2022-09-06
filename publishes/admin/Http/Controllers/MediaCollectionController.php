<?php

namespace Admin\Http\Controllers;

use Admin\Http\Resources\MediaCollectionResource;
use Admin\Http\Resources\StoredResource;
use App\Models\File;
use App\Models\MediaCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaCollectionController
{
    /**
     * Get MediaCollection items.
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        return MediaCollectionResource::collection(MediaCollection::all());
    }

    /**
     * Get MediaCollection item.
     *
     * @param  Request                 $request
     * @param  MediaCollection         $collection
     * @return MediaCollectionResource
     */
    public function item(Request $request, MediaCollection $collection)
    {
        return new MediaCollectionResource($collection);
    }

    /**
     * Create a new MediaCollection.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'key'   => 'required|string|unique:file_collections,key',
        ]);

        // Enforce sluggified slug
        if (array_key_exists('slug', $validated)) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $collection = MediaCollection::create($validated);

        return new StoredResource($collection);
    }

    /**
     * Destroy a MediaCollection.
     *
     * @param  Request         $request
     * @param  MediaCollection $collection
     * @return void
     */
    public function destroy(Request $request, MediaCollection $collection)
    {
        $collection->delete();
    }

    /**
     * Add a list of files to the collection.
     *
     * @param  Request         $request
     * @param  MediaCollection $collection
     * @return void
     */
    public function add(Request $request, MediaCollection $collection)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        File::whereIn('id', $request->ids)->get()
            ->each(function (File $file) use ($collection) {
                if ($collection->isAttachedTo($file)) {
                    return;
                }

                $file->attach($collection);
            });
    }

    /**
     * Remove a list of files from the collection.
     *
     * @param  Request         $request
     * @param  MediaCollection $collection
     * @return void
     */
    public function remove(Request $request, MediaCollection $collection)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        File::whereIn('id', $request->ids)->get()
            ->each(function (File $file) use ($collection) {
                if (! $collection->isAttachedTo($file)) {
                    return;
                }

                $file->detach($collection);
            });
    }

    /**
     * Upload files.
     *
     * @param  Request         $request
     * @param  MediaCollection $collection
     * @return void
     */
    public function upload(Request $request, MediaCollection $collection)
    {
        collect($request->files->get('files'))
            ->each(function (UploadedFile $file) use ($collection) {
                DB::transaction(function () use ($collection, $file) {
                    $file = File::createFromUploadedFile($file);

                    $file->save();

                    $file->attach($collection);
                });
            });
    }
}
