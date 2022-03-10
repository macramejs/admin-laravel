<?php

namespace {{ namespace }}\Http\Controllers;

use {{ namespace }}\Http\Indexes\{{ model_name }}Index;
use {{ namespace }}\Http\Resources\{{ model_name }}ListResource;
use {{ namespace }}\Http\Resources\{{ model_name }}Resource;
use {{ namespace }}\Ui\Page as AdminPage;
use App\Models\{{ page_model }};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Macrame\Admin\Pages\Ui\PagesIndexPage;
use Macrame\Admin\Pages\Ui\PagesShowPage;

class {{ page_model }}Controller
{
    /**
     * Ship index page.
     *
     * @param  Page $page
     * @return Page
     */
    public function items(Request $request, {{ model_name }}Index $index)
    {
        return $index->items(
            $request,
            {{ page_model }}::query()
        );
    }

    /**
     * Show the ship index page for the admin application.
     *
     * @return AdminPage
     */
    public function index(Request $request, AdminPage $adminPage): AdminPage
    {
        $pages = {{ page_model }}::root();

        return $adminPage
            ->with('pages', {{ model_name }}ListResource::collection($pages));
    }

    public function show({{ page_model }} $page, AdminPage $adminPage)
    {
        $pages = {{ page_model }}::root();

        return $adminPage
            ->with('page', new {{ model_name }}Resource($page));
            ->with('pages', {{ model_name }}ListResource::collection($pages));
    }

    public function update(Request $request, {{ page_model }} $page)
    {
        $page->update([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $site = {{ page_model }}::make([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'template' => $request->template,
        ]);

        $site->save();

        return redirect()->back();
    }

    public function order(Request $request)
    {
        $this->updateOrder($request->order);

        return redirect()->back();
    }

    public function updateOrder($order, $parentId = null)
    {
        foreach ($order as $position => $site) {
            Page::whereKey($site['id'])->update([
                'parent_id'    => $parentId,
                'order_column' => $position,
            ]);

            $this->updateOrder($site['children'], $site['id']);
        }
    }

    public function upload(Request $request, {{ page_model }} $page)
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
