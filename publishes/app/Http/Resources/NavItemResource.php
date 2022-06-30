<?php

namespace App\Http\Resources;

use App\Models\NavItem;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin NavItem
 */
class NavItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var NavItem
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
            'link'     => $this->link->url(),
            'name'     => $this->title,
            'children' => static::collection(
                $this->children->sortBy('order_column')
            ),
        ];
    }
}
