<?php

namespace Admin\Http\Resources;

use App\Models\{{ model }};
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin {{ model }}
 */
class SiteListResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var {{ model }}
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request                                        $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'value'    => parent::toArray($request),
            'children' => static::collection($this->children->sortBy('order_column')),
        ];
    }
}
