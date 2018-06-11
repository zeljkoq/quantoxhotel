<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'artist' => $this->artist,
            'track' => $this->track,
            'link' => $this->link,
            'duration' => $this->duration,
            'edit' => $this->edit_index,
            'id' => $this->id,
            'admin' => '1',
            'user' => '0',
            'updated_by' => User::where('id', $this->updated_by)->pluck('name')->first(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
