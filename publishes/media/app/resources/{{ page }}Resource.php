<?php

namespace {{ namespace }}\Http\Resources;

use App\Models\{{ file_model }};
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin {{ file_model }}
 */
class {{ page }}Resource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var {{ file_model }}
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
            'url' => $this->getUrl(),
            'readable_size' => $this->getReadableSize(),
            'created_at' => new DateTimeResource($this->created_at),
            'updated_at' => new DateTimeResource($this->updated_at),
        ]);
    }
}
