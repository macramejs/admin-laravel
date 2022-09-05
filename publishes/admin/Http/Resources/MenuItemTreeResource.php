<?php

namespace Admin\Http\Resources;

use App\Models\MenuItem;
use Macrame\Tree\TreeResource;

/**
 * @mixin MenuItem
 */
class MenuItemTreeResource extends TreeResource
{
    /**
     * The resource instance.
     *
     * @var MenuItem
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
            'id'        => $this->id,
            'title'     => $this->title,
            'link'      => $this->link?->value,
            'is_public' => $this->isPublic(),
        ];
    }
}
