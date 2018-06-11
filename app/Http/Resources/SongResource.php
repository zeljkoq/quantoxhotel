<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
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
            'artist' => $this->artist,
            'track' => $this->track,
            'link' => $this->link,
            'duration' => $this->duration,
            'updated_by' => User::where('id', $this->updated_by)->pluck('name')->first(),

        ];
    }
}
