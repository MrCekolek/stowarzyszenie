<?php

namespace App\Models;

class AffiliationUser extends BaseModel {
    protected $fillable = [
        'title',
        'institution',
        'department',
        'street',
        'city',
        'country',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
