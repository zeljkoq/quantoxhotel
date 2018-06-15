<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Party
 * @package App\Models
 */
class Party extends Model
{
    /**
     * @var string
     */
    protected $table = 'parties';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * @param $party_id
     * @return bool
     */
    public function hasSongs($party_id)
    {
        $songs = Playlist::where('party_id', $party_id)->get();

        if ($songs) {
            return true;
        }
        return false;
    }

}
