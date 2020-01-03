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
}
