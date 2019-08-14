<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public $timestamps = false;

    public function scopeEmail($query, $email) {
        return $query->where('email', $email);
    }

    public function scopeToken($query, $token) {
        return $query->where('token', $token);
    }
}
