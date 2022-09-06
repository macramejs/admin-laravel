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
            'name'        => $this->name,
            'slug'        => $this->slug,
            'preview_key' => $this->preview_key,
            'template'    => (string) $this->template,
            'parent_id'   => $this->parent_id,

            // dynamic
            'content'    => $this->content->toArray(),
            'attributes' => $this->attributes->toArray(),
            'full_slug'  => $this->getFullSlug(),

            // livetime
            'publish_at'         => $this->publish_at,
            'is_live'            => $this->is_live,
            'has_been_published' => $this->publish_at < now(),
        ];
    }
}
