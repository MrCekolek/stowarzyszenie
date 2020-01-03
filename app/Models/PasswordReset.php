<?php

namespace App\Models;

class PasswordReset extends BaseModel {
    protected $primaryKey = 'login_email';

    protected $fillable = [
        'login_email',
        'token'
    ];

    public $timestamps = false;
}
