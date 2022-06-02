<?php

namespace Admin\Http\Controllers;

use Admin\Http\Controllers\Traits\PageLinks;
use Admin\Http\Indexes\PageIndex;
use Admin\Http\Resources\LinkOptionResource;
use Admin\Http\Resources\PageResource;
use Admin\Http\Resources\PageTreeResource;
use Admin\Ui\Page as AdminPage;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PageController
{
    use PageLinks;

    /**
     * Page index page.
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
     * Show the index page for the admin application.
     *
     * @return AdminPage
     */
    public function index(Request $request, AdminPage $adminPage): AdminPage
    {
        $pages = Page::root();

        return $adminPage
            ->page('Page/Index')
            ->with('pages', PageTreeResource::collection($pages));
    }

    /**
     * Show the page.
     *
     * @param {{ Model }} $page
     * @param  AdminPage $adminPage
     * @return AdminPage
     */
    public function show(Page $page, AdminPage $adminPage, $tab = 'content')
    {
        if (! in_array($tab, ['content', 'meta', 'settings'])) {
            abort(404);
        }

        $pages = Page::root();

        $linkOptions = $this->linkOptions();

        return $adminPage
            ->page('Page/Show')
            ->with('tab', $tab)
            ->with('page', new PageResource($page))
            ->with('link-options', LinkOptionResource::collection($linkOptions))
            ->with('pages', PageTreeResource::collection($pages));
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
