<?php

namespace App\Models;

class PasswordReset extends BaseModel {
    protected $primaryKey = 'login_email';

    protected $fillable = [
        'login_email',
        'token'
    ];

    public $timestamps = false;

    public function scopeLoginEmail($query, $email) {
        return $query->where('login_email', $email);
    }

    public function scopeToken($query, $token) {
        return $query->where('token', $token);
    }
}
