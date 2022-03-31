<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Http\Indexes\{{ model }}Index;
use {{ namespace }}\Http\Resources\{{ model }}TreeResource;
use {{ namespace }}\Http\Resources\{{ model }}Resource;
use {{ namespace }}\Ui\Page as AdminPage;
use App\Models\{{ model }};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Macrame\Admin\Pages\Ui\PagesIndexPage;
use Macrame\Admin\Pages\Ui\PagesShowPage;

class {{ model }}Controller
{
    /**
     * Ship index page.
     *
     * @param  Page $page
     * @return Page
     */
    public function items(Request $request, {{ model }}Index $index)
    {
        return $index->items(
            $request,
            {{ model }}::query()
        );
    }

    /**
     * Show the ship index page for the admin application.
     *
     * @return AdminPage
     */
    public function index(Request $request, AdminPage $adminPage): AdminPage
    {
        $pages = {{ model }}::root();

        return $adminPage
            ->page('Page/Index')
            ->with('pages', {{ model }}TreeResource::collection($pages));
    }

    /**
     * Show the {{ name }}.
     *
     * @param {{ Model }} $page
     * @param AdminPage $adminPage
     * @return AdminPage
     */
    public function show({{ model }} $page, AdminPage $adminPage)
    {
        $pages = {{ model }}::root();

        return $adminPage
            ->page('Page/Show')
            ->with('page', new {{ model }}Resource($page))
            ->with('pages', {{ model }}TreeResource::collection($pages));
    }

    /**
     * Update the {{ name }}.
     *
     * @param Request $request
     * @param {{ model }} $page
     * @return void
     */
    public function update(Request $request, {{ model }} $page)
    {
        $validated = $request->validate([
            'content' => 'array',
            'attributes' => 'array'
        ]);

        $page->update($validated);

        return redirect()->back();
    }

    /**
     * Update the meta information of the {{ name }}.
     *
     * @param Request $request
     * @param {{ model }} $page
     * @return void
     */
    public function meta(Request $request, {{ model }} $page)
    {
        $validated = $request->validate([
            // ...
        ]);

        $page->update($validated);

        return redirect()->back();
    }

    /**
     * Store a new {{ name }}.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $page = {{ model }}::make([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'template' => $request->template,
        ]);

        $page->save();

        return redirect()->back();
    }

    /**
     * Update the order for of the {{ name }} tree.
     *
     * @param Request $request
     * @return void
     */
    public function order(Request $request)
    {
        {{ model }}::updateOrder($request->order);

        return redirect()->back();
    }

    public function upload(Request $request, {{ model }} $page)
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
