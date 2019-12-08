<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreferenceUser extends Model {
    protected $fillable = [
        'avatar',
        'time_zone',
        'lang',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeUserId($query, $userId) {
        return $query->where('user_id', $userId);
    }
}
