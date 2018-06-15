<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegularPartyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => \Carbon\Carbon::parse($this->date)->format('d/m/Y H:i'),
            'duration' => $this->duration,
            'capacity' => $this->capacity,
            'description' => $this->description,
            'tags' => $this->tags,
            'cover_image' => $this->cover_image,
            'start' => $this->start
        ];
    }
}
