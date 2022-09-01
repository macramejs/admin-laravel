<?php

namespace Admin\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin File
 */
class MediaResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var File
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
            'url'           => $this->getUrl(),
            'readable_size' => $this->getReadableSize(),
            // 'created_at'    => new DateTimeResource($this->created_at),
            // 'updated_at'    => new DateTimeResource($this->updated_at),
        ]);
    }
}
