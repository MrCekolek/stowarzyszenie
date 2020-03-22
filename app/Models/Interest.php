<?php

namespace App\Models;

class Interest extends BaseModel {
    protected $fillable = [
        'name_en',
        'name_pl',
        'name_ru'
    ];

    public function users() {
        return $this->belongsToMany(User::class)
            ->using(InterestUser::class);
    }

    public function tracks() {
        return $this->hasMany(Track::class);
    }
}
