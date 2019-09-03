<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    protected $primaryKey = 'login_email';

    protected $fillable = [
        'login_email',
        'token',
        'created_at'
    ];

    public $timestamps = false;

    public function scopeLoginEmail($query, $email) {
        return $query->where('login_email', $email);
    }

    public function scopeToken($query, $token) {
        return $query->where('token', $token);
    }
}
