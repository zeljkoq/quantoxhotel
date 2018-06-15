<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinedParties extends Model
{
    protected $table = 'joined_parties';
    protected $fillable = [
        'user_id',
        'party_id'
    ];
}
