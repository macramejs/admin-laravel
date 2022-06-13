<?php

namespace Admin\Http\Resources;

use App\Models\FileCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FileCollection
 */
class FileCollectionResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var FileCollection
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
