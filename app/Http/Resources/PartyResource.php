<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class PartyResource extends JsonResource
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
            'date' => \Carbon\Carbon::parse($this->date)->format('d/m/Y G:H'),
            'duration' => $this->duration,
            'capacity' => $this->capacity,
            'description' => $this->description,
            'tags' => $this->tags,
            'updated_by' => User::where('id', $this->updated_by)->pluck('name')->first(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'edit' => $this->edit_index,
        ];
    }
}
