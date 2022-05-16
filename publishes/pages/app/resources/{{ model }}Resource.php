<?php

namespace Admin\Http\Resources;

use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Page
 */
class PageResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Page
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
            'id' => $this->id,

            // static
            'name' => $this->name,
            'slug' => $this->slug,

            // dynamic
            'content' => $this->content->toArray(),
            'attributes' => $this->attributes,

            'full_slug' => $this->getFullSlug(),
            
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ]
        ];
    }
}
