<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'code' => $this->code,
            'description' => $this->description,
            'profile_picture' => asset('storage/' . $this->profile_picture),
            'cover' => asset('storage/' . $this->cover),
            'address' => $this->address,
            'owner' => new UserResource($this->user),
            'my_role' => '',
        ];
    }
}
