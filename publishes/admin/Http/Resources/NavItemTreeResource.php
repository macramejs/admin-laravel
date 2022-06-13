<?php

namespace Admin\Http\Resources;

use App\Models\NavItem;
use Macrame\Tree\TreeResource;

/**
 * @mixin NavItem
 */
class NavItemTreeResource extends TreeResource
{
    /**
     * The resource instance.
     *
     * @var NavItem
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link->value,
        ];
    }
}
