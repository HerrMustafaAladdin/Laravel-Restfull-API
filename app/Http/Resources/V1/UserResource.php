<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'Name'      =>  $this->name,
            'Email'     =>  $this->email,
            'Create'    =>  $this->created_at->format('Y/m/d')
        ];
    }
}
