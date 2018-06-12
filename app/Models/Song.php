<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Song
 * @package App\Models
 */
class Song extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'artist',
        'track',
        'link',
        'duration',
        'updated_by'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @var array
     */
    protected $appends = ['delete', 'edit_index'];


    /**
     * @return string
     */
    public function getEditIndexAttribute()
    {
        return route('song.edit.index', $this->id);
    }

    /**
     * @return string
     */
    public function getDeleteAttribute()
    {
        return route('song.delete', $this->id);
    }
}
