<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\PageIndex;
use Admin\Http\Resources\PageResource;
use Admin\Http\Resources\StoredResource;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController
{
    /**
     * Get Page items.
     *
     * @param  Page $page
     * @return Page
     */
    public function items(Request $request, PageIndex $index)
    {
        return $index->items(
            $request,
            Page::query(),
            PageResource::class
        );
    }

    /**
     * Get Page item.
     *
     * @param  Request      $request
     * @param  Page         $page
     * @return PageResource
     */
    public function item(Request $request, Page $page)
    {
        return new PageResource($page);
    }

    /**
     * Update the page.
     *
     * @param  Request $request
     * @param  Page    $page
     * @return void
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'content'          => 'array',
            'attributes'       => 'array',
            'slug'             => 'sometimes|nullable',
            'name'             => 'sometimes|string',
            'is_live'          => 'sometimes|boolean',
            'publish_at'       => 'sometimes|date|nullable',
            'meta.title'       => 'sometimes|string|nullable',
            'meta.description' => 'sometimes|string|nullable',
        ]);

        if (array_key_exists('meta', $validated)) {
            foreach ($validated['meta'] as $key => $value) {
                $validated["meta_{$key}"] = $value;
            }

            unset($validated['meta']);
        }

        // Enforce sluggified slug
        if (array_key_exists('slug', $validated)) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $page->update($validated);
    }

    /**
     * Store a new page.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $page = $request->parent_id
            ? Page::where('id', $request->parent_id)->firstOrFail()
            : null;

        $validated = $request->validate([
            'name'     => 'required|string',
            'slug'     => 'required|string',
            'template' => 'required|string',
        ]);

        $page = Page::make([
            ...$validated,
            'parent_id' => $request->parent_id,
            'slug'      => Str::slug($request->slug ?: $request->name),
        ]);

        $page->creator_id = $request->user()->id;
        $page->preview_key = Str::uuid();

        $page->save();

        return new StoredResource($page);
    }

    /**
     * Destroy the given page.
     *
     * @param  Request  $request
     * @param  Page     $page
     * @return Response
     */
    public function destroy(Request $request, Page $page)
    {
        $page->delete();

        return response()->noContent();
    }

    public function upload(Request $request, Page $page)
    {
        $validated = $request->validate([
            'file' => 'required',
        ]);

        $file = File::fromUpload($request->file);
        $file->group = $request->file_group;
        $file->save();

        $page->addFile($validated['file'])->save();

        return PageResource::make($page);
    }

    /**
     * Duplicate a page with all contents.
     *
     * @param  Request          $request
     * @param  Page             $page
     * @return RedirectResponse
     */
    public function duplicate(Request $request, Page $page)
    {
        $page = $page->replicate();
        $page->name = $request->name;
        $page->slug = Str::slug($request->name);
        $page->save();

        return PageResource::make($page);
    }
}
