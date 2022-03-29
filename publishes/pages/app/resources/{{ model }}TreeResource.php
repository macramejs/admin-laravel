<?php

namespace Admin\Http\Resources;

use App\Models\{{ model }};
use Macrame\Tree\TreeResource;

/**
 * @mixin {{ model }}
 */
class {{ model }}TreeResource extends TreeResource
{
    /**
     * The resource instance.
     *
     * @var {{ model }}
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
