<?php

namespace Macrame\Admin\Pages\Resources;

use Macrame\Admin\Pages\Contract\Page;
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
