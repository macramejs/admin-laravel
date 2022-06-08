<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request                                        $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'template'   => $this->template,
            'content'    => $this->content->parse(),
            'attributes' => $this->attributes->parse(),
            'meta'       => [
                'title'       => $this->meta_title,
                'description' => $this->meta_description,
            ],
        ];
    }
}
