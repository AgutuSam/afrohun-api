<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        'name'=> $this->name,
        'email'=> $this->email,
        'password'=> $this->password,
        'firstname'=> $this->firstname,
        'lastname'=> $this->lastname,
        'type'=> $this->type,
        'profile_picture'=> $this->profile_picture,
        'active'=> $this->active,
        'expertise'=> $this->expertise,
        'experience'=> $this->experience,
        'innovations'=> $this->innovations,
        'links'=> $this->links,
        'certs'=> $this->certs, 
        'address'=> $this->address,
        'latitude'=> $this->latitude,
        'longitude'=> $this->longitude,
        'posts'=>PostResource::collection($this->whenLoaded('posts'))
        ];
    }
}
