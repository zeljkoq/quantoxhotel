<?php

namespace App\Http\Resources;

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
            'edit' => $this->edit_index,
            'id' => $this->id,
            'admin' => '1'
        ];
    }
}
