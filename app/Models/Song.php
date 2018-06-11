<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Song extends Model
{

    protected $fillable = [
        'artist',
        'track',
        'link',
        'duration',
        'updated_by'
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
