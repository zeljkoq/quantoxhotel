<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $fillable = [
        'song_id',
        'party_id',
        'user_id'
    ];

    public function songs()
    {
        return $this->hasMany(Song::class, 'id');
    }
    public function parties()
    {
        return $this->hasMany(Party::class, 'id');
    }

}
