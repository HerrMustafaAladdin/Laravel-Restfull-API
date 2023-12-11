<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID'    =>  $this->id,
            'Title' =>  $this->title,
            'Image' =>  $this->image,
            'Body'  =>  $this->body,
            'Date'  =>  $this->created_at->format('Y/m/d')
        ];
    }
}
