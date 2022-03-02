<?php

namespace Macrame\CMS\Pages\Ui;

use Illuminate\Support\Collection;
use Inertia\Response;
use Macrame\CMS\Pages\Resources\PageListResource;
use Macrame\CMS\Support\BasePage;

class PagesIndexPage extends BasePage
{
    /**
     * The inertia component name.
     *
     * @var string
     */
    protected $inertiaComponent = 'Pages/Index';

    /**
     * PagesList Resource namespace.
     *
     * @var string
     */
    protected $pageListResource = PageListResource::class;

    /**
     * Create new PagesIndex instance.
     *
     * @param Collection $pages
     */
    public function __construct(protected Collection $pages)
    {
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
    }
}
