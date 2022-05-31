<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Collection
 */
class NavResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Collection
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'items' => NavItemResource::collection($this->all())
        ];
    }
}
