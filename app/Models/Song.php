<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Song extends Model
{

    protected $fillable = [
        'user_id',
        'artist',
        'track',
        'link',
	    'duration'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $appends = ['delete', 'edit_index'];


    public function getEditIndexAttribute()
    {
        return route('song.edit.index', $this->id);
    }

    public function getDeleteAttribute()
    {
        return route('song.delete', $this->id);
    }
}
