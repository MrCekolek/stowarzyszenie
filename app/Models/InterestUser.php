<?php

namespace App\Models;

class InterestUser extends BasePivot {
    protected $table = 'interest_user';

    protected $fillable = [
        'interest_id',
        'user_id'
    ];

    public function interest() {
        return $this->belongsTo(Interest::class);
    }
}
