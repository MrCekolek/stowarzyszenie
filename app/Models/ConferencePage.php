<?php

namespace App\Models;

class ConferencePage extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru',
        'content_pl',
        'content_en',
        'content_ru',
        'conference_id',
    ];

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
