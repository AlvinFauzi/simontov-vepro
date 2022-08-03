<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'roleUser' => $this->roleUser,
            'permission' => $this->permission,
            'status' => $this->email_verified_at ? '<span class="text-success"><i class="icon-check"></i> ' . trans('lang.verify') . '</span>'
                : '<span class="text-danger"><i class="icon-close"></i> ' . trans('lang.notVerify') . '</span>',
        ];
    }
}
