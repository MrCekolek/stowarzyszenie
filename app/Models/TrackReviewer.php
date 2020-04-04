<?php

namespace App\Models;

class TrackReviewer extends BaseModel {
    protected $table = 'track_reviewer';

    protected $fillable = [
        'track_id',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
