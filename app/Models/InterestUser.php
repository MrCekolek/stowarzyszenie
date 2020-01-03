<?php

namespace App\Models;

class InterestUser extends BasePivot {
    protected $table = 'interest_users';

    protected $fillable = [
        'selected',
        'interest_id',
        'user_id'
    ];
}
