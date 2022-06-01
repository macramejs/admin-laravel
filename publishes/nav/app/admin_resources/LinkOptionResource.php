<?php

namespace Admin\Http\Resources;

use Admin\Http\Resources\Options\LinkOption;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LinkOption
 */
class LinkOptionResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var LinkOption
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
            'link'  => $this->link,
            'title' => $this->title,
        ];
    }
}
