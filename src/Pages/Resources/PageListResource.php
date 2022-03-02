<?php

namespace Macrame\CMS\Pages\Resources;

use Macrame\CMS\Pages\Contract\Page;
use Macrame\Tree\TreeResource;

/**
 * @mixin Page
 */
class PageListResource extends TreeResource
{
    /**
     * The resource instance.
     *
     * @var Page
     */
    public $resource;
}
