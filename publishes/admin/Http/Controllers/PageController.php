<?php

namespace Admin\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Admin\Ui\Page as AdminPage;
use Admin\Http\Indexes\PageIndex;
use Illuminate\Http\RedirectResponse;
use Admin\Http\Resources\PageResource;
use Illuminate\Support\Facades\Redirect;
use Admin\Http\Resources\PageTreeResource;
use Admin\Http\Controllers\Traits\PageLinks;
use Admin\Http\Resources\LinkOptionResource;
use Admin\Http\Resources\Options\LinkOption;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
            Page::query()
        );
    }

    /**
     * Get Page item.
     *
     * @param Request $request
     * @param Page $page
     * @return PageResource
     */
    public function item(Request $request, Page $page)
    {
        return new PageResource($page);
    }

    /**
     * Get the pages tree.
     *
     * @return AnonymousResourceCollection
     */
    public function tree()
    {
        return PageTreeResource::collection(Page::root());
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
            'content'    => 'array',
            'attributes' => 'array',
            'slug'       => 'sometimes|nullable',
            'name'       => 'sometimes|string',
            'is_live'    => 'sometimes|boolean',
            'publish_at' => 'sometimes|date|after:now|nullable',
        ]);

        // Enforce sluggified slug
        if (array_key_exists('slug', $validated)) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $page->update($validated);

        return redirect()->back();
    }

    /**
     * Update the meta information of the page.
     *
     * @param  Request $request
     * @param  Page    $page
     * @return void
     */
    public function meta(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title'       => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            $validated['meta_'.$key] = $value;
        }

        $page->update($validated);

        return redirect()->back();
    }

    /**
     * Store a new page.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $page = Page::make([
            'parent_id' => $request->parent,
            'name'      => $request->name,
            'slug'      => Str::slug($request->slug ?: $request->name),
            'template'  => $request->template,
        ]);

        $page->creator_id = $request->user()->id;
        $page->preview_key = Str::uuid();

        $page->save();

        return redirect()->route('admin.pages.show', [
            'page' => $page,
        ]);
    }

    /**
     * Destroy the given page.
     *
     * @param  Request          $request
     * @param  Page             $page
     * @return RedirectResponse
     */
    public function destroy(Request $request, Page $page)
    {
        $page->delete();

        return redirect(route('admin.pages.index'));
    }

    /**
     * Update the order for of the page tree.
     *
     * @param  Request $request
     * @return void
     */
    public function order(Request $request)
    {
        Page::updateOrder($request->order);

        return redirect()->back();
    }

    public function upload(Request $request, Page $page)
    {
        $validated = $request->validate([
            'file' => 'required',
        ]);

        $file = File::fromUpload($request->file);
        $file->group = $request->file_group;
        $file->save();

        // $collection = Collection::find($request->collection);
        // $collection->addFile($file);

        // $page->addFile($file);

        $page->addFile($validated['file'])->save();

        return Redirect::route('admin.sites.show', ['site' => $page]);
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

        return redirect()->route('admin.pages.show', [
            'page' => $page,
        ]);
    }
}
