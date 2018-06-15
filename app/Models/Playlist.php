<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Playlist
 * @package App\Models
 */
class Playlist extends Model
{
    /**
     * @var string
     */
    protected $table = 'playlists';
    /**
     * @var array
     */
    protected $fillable = [
        'song_id',
        'party_id',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs()
    {
        return $this->hasMany(Song::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parties()
    {
        return $this->hasMany(Party::class, 'id');
    }

}
