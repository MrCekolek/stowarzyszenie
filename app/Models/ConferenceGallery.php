<?php

namespace App\Models;

class ConferenceGallery extends BaseModel {
    protected $fillable = [
        'file',
        'conference_id'
    ];

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
