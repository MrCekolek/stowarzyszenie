<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestUser extends Model {
    protected $table = 'interest_users';

    protected $fillable = [
        'interest_id',
        'user_id',
    ];
}
