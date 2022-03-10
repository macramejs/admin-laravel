<?php

namespace Admin\Http\Resources;

use App\Models\{{ model_name }};
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin {{ model_name }}
 */
class SiteResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var {{ model_name }}
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
