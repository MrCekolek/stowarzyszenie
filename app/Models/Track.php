<?php

namespace App\Models;

class Track extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru',
        'colour',
        'interest_id',
        'conference_id'
    ];

    public function interest() {
        return $this->belongsTo(Interest::class);
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }

    public function trackArticles() {
        return $this->hasMany(TrackArticle::class);
    }

    public function trackReviewers() {
        return $this->belongsToMany(User::class, 'track_reviewer')
            ->using(TrackReviewer::class);
    }

    public function trackChairs() {
        return $this->belongsToMany(User::class, 'track_chair')
            ->using(TrackChair::class);
    }
}
