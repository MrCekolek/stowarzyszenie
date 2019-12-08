<?php

namespace App\Models;

class PreferenceUser extends BaseModel {
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
