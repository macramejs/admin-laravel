<?php

namespace Admin\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class SystemUserResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var User
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
            'id'                 => $this->id,
            'name'               => $this->name,
            'email'              => $this->email,
            'is_admin'           => $this->is_admin,
            'has_verified_email' => $this->hasVerifiedEmail(),
        ];
    }
}
