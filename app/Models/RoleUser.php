<?php

namespace App\Models;

class RoleUser extends BasePivot {
    protected $table = 'role_user';

    protected $fillable = [
        'role_id',
        'user_id'
    ];
}
