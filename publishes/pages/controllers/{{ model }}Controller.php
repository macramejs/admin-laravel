<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the page.
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        $page = Page::fromRequestOrFail($request);

        $this->abortIfPageCannotBeViewed($request, $page);

        $page->content->parse();
        $page->attributes->parse();

        return Inertia::render('Pages/Show', [
            'page' => $page
        ]);
    }

    /**
     * Determines whether a page can be viewed, aborts 404 otherwise.
     * 
     * @param  Request $request
     * @param  Page $page
     * @return void
     */
    protected function abortIfPageCannotBeViewed(Request $request, Page $page)
    {
        if($page->is_live) {
            if(is_null($page->publish_at) || $page->publish_at < now()) {
                return;
            }
        }

        // If the page is not live and not published, it can only be viewed when 
        // the correct preview_key is used.
        if($request->preview == $page->preview_key 
            && !is_null($page->preview_key)) {
            return;
        }

        abort(404);
    }
}
