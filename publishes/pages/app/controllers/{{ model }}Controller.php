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

    public function show({{ model }} $page, AdminPage $adminPage)
    {
        $pages = {{ model }}::root();

        return $adminPage
            ->page('Page/Show')
            ->with('page', new {{ model }}Resource($page))
            ->with('pages', {{ model }}TreeResource::collection($pages));
    }

    public function update(Request $request, {{ model }} $page)
    {
        $page->update([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

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

    public function order(Request $request)
    {
        $this->updateOrder($request->order);

        return redirect()->back();
    }

    public function updateOrder($order, $parentId = null)
    {
        foreach ($order as $position => $page) {
            Page::whereKey($page['id'])->update([
                'parent_id'    => $parentId,
                'order_column' => $position,
            ]);

            $this->updateOrder($page['children'], $page['id']);
        }
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
