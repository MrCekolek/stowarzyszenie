<?php

namespace App\Models;

class TrackChair extends BaseModel {
    protected $table = 'track_chair';

    protected $fillable = [
        'track_id',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
