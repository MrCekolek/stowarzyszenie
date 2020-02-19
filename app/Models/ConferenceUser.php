<?php

namespace App\Models;

class ConferenceUser extends BasePivot {
    protected $fillable = [
        'conference_id',
        'user_id',
        'status'
    ];
}
