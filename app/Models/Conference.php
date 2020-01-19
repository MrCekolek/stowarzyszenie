<?php

namespace App\Models;

class Conference extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru'
    ];

    public function conferencePages() {
        return $this->hasMany(ConferencePage::class);
    }

    public function tracks() {
        return $this->hasMany(Track::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)
            ->using(ConferenceUser::class);
    }
}
