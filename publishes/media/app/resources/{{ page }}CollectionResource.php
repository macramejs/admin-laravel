<?php

namespace {{ namespace }}\Http\Resources;

use App\Models\{{ page }}Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin {{ page }}Collection
 */
class {{ page }}CollectionResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var {{ page }}Collection
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
            //
        ]);
    }
}
