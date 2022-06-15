<?php

namespace Admin\Http\Resources;

use App\Models\Menu;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Menu
 */
class MenuResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Menu
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
            'label' => $this->title,
            'value' => $this->type,
        ];
    }
}
