<?php

namespace {{ namespace }}\Http\Resources;

use {{ namespace }}\Http\Resources\Models\RouteItem;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RouteItem
 */
class RouteItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var RouteItem
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
            'url'  => $this->url,
            'title' => $this->title,
        ];
    }
}
