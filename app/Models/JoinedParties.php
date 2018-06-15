<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JoinedParties
 * @package App\Models
 */
class JoinedParties extends Model
{
    /**
     * @var string
     */
    protected $table = 'joined_parties';
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'party_id'
    ];
}
