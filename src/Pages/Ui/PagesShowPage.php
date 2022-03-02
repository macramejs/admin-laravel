<?php

namespace Macrame\CMS\Pages\Ui;

use Illuminate\Support\Collection;
use Inertia\Response;
use Macrame\CMS\Pages\Contracts\Page;
use Macrame\CMS\Pages\Resources\PageListResource;
use Macrame\CMS\Pages\Resources\PageResource;
use Macrame\CMS\Support\BasePage;

class PagesShowPage extends BasePage
{
    /**
     * The inertia component name.
     *
     * @var string
     */
    protected $inertiaComponent = 'Pages/Show';

    /**
     * PageList Resource namespace.
     *
     * @var string
     */
    protected $pageListResource = PageListResource::class;

    /**
     * Page Resouce namespace.
     *
     * @var string
     */
    protected $pageResource = PageResource::class;

    /**
     * Create new PagesIndex instance.
     *
     * @param Page       $page
     * @param Collection $pages
     */
    public function __construct(
        protected Page $page,
        protected Collection $pages
    ) {
        //
    }

    /**
     * Mount the page.
     *
     * @param  Response $response
     * @param  Response $inertia
     * @return void
     */
    public function mount(Response $inertia)
    {
        $inertia->with(
            'pages',
            $this->pageListResource::collection($this->pages)
        );

        $inertia->with(
            'page',
            new $this->pageResource($this->page)
        );
    }
}
