<?php

namespace Admin\Http\Resources;

use App\Models\Page;
use Macrame\Tree\TreeResource;

/**
 * @mixin Page
 */
class PageTreeResource extends TreeResource
{
    /**
     * The resource instance.
     *
     * @var Page
     */
    public $resource;

    /**
     * Gets the value array containing all required attributes.
     *
     * @param  \Illuminate\Http\Request                                        $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function value($request)
    {
        return parent::value($request);
    }
}
