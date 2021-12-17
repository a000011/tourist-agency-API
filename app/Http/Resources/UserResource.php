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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'avatar' => $this->avatar,
        ];
    }

    public function getArray()
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'avatar' => $this->avatar,
        ];
    }
}
