<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\MediaIndex;
use Admin\Http\Resources\MediaCollectionResource;
use Admin\Http\Resources\MediaResource;
use Admin\Ui\Page;
use App\Models\File;
use App\Models\MediaCollection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @module media
 */
class MediaController
{
    /**
     * Media index page.
     *
     * @param  Request $request
     * @param  PageIndex $index
     * @return PageIndex
     */
    public function items(Request $request, MediaIndex $index)
    {
        return $index->items(
            request: $request,
            query: File::query(),
            resource: MediaResource::class
        );
    }

    /**
     * Show a single file.
     *
     * @param Request $request
     * @param File $file
     * @return MediaResource
     */
    public function item(Request $request, File $file)
    {
        return new MediaResource($file);
    }

    /**
     * Show the Media index.
     *
     * @param  Page $page
     * @return Page
     */
    public function index(Page $page, $mimeType = null)
    {
        $collections = MediaCollection::withCount('files')->get();

        return $page
            ->page('Media/Index')
            ->with('collections', MediaCollectionResource::collection($collections));
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

        File::whereIn('id', $request->ids)->delete();

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
                File::createFromUploadedFile($file);
            });

        return response()->json();
    }
}
