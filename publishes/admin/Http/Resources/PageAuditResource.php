<?php

namespace Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageAuditResource extends JsonResource
{
    /**
     * The resource instance.
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
        $old = $this->old_values;

        if (array_key_exists('content', $old)) {
            $old['content'] = json_decode($old['content']);
        }

        if (array_key_exists('attributes', $old)) {
            $old['attributes'] = json_decode($old['attributes']);
        }

        $new = $this->new_values;

        if (array_key_exists('content', $new)) {
            $new['content'] = json_decode($new['content']);
        }
        if (array_key_exists('attributes', $new)) {
            $new['attributes'] = json_decode($new['attributes']);
        }

        return [
            'id'         => $this->id,
            'user'       => $this->user,
            'event'      => $this->event,
            'old_values' => $old,
            'new_values' => $new,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
