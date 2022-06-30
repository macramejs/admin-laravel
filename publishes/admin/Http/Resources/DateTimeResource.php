<?php

namespace Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @mixin Carbon
 */
class DateTimeResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Carbon
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
        $this->setLocale(app()->getLocale());

        return [
            'label'         => $this->toRfc7231String(),
            'readable_diff' => $this->diffForHumans(),
        ];
    }
}
