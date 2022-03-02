<?php

namespace Macrame\CMS\Pages\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Macrame\CMS\Pages\Contract\Page;

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
        return array_merge(parent::toArray($request), [
            'full_slug' => $this->getFullSlug(),
        ]);
    }
}
