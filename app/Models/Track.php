<?php

namespace App\Models;

class Track extends BaseModel {
    protected $fillable = [
        'conference_id'
    ];

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
