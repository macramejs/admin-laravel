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
use Macrame\Admin\Pages\Ui\PagesShowPage;
use Admin\Http\Resources\PageTreeResource;
use Macrame\Admin\Pages\Ui\PagesIndexPage;

class PageController
{
    /**
     * Ship index page.
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
     * Show the ship index page for the admin application.
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
     * @param AdminPage $adminPage
     * @return AdminPage
     */
    public function show(Page $page, AdminPage $adminPage, $tab = 'content')
    {
        if (! in_array($tab, ['content', 'meta'])) {
            abort(404);
        }

        $pages = Page::root();

        return $adminPage
            ->page('Page/Show')
            ->with('tab', $tab)
            ->with('page', new PageResource($page))
            ->with('pages', PageTreeResource::collection($pages));
    }

    /**
     * Update the page.
     *
     * @param Request $request
     * @param Page $page
     * @return void
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'content' => 'array',
            'attributes' => 'array',
            'slug' => 'sometimes|string'
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
     * @param Request $request
     * @param Page $page
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
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $page = Page::make([
            'parent_id' => $request->parent,
            'name'     => $request->name,
            'slug'     => Str::slug($request->slug ?: $request->name),
            'template' => $request->template,
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
     * @param Request $request
     * @param Page $page
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
     * @param Request $request
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
}
