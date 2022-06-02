<?php

namespace App\Http\Resources;

use App\Http\Resources\Wrapper\Image;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Image
 */
class ImageResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Image
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
            'url'   => $this->image->getUrl(),
            'alt'   => $this->alt,
            'title' => $this->title,
        ];
    }
}
