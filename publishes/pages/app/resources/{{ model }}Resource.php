<?php

namespace Admin\Http\Resources;

use App\Models\{{ model }};
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin {{ model }}
 */
class {{ model }}Resource extends JsonResource
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
        return array_merge(parent::toArray($request), [
            'full_slug' => $this->getFullSlug(),
        ]);
    }
}
