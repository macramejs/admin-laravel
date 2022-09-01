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
        setlocale(LC_TIME, 'de_DE.utf8');

        return [
            'original'      => $this->toDateTimeString(),
            'iso'           => $this->toIso8601String(),
            'formatted'     => $this->format('d.m.Y'),
            'label'         => $this->formatLocalized('%d. %B %Y'),
            'readable_diff' => $this->diffForHumans(),
        ];
    }
}
