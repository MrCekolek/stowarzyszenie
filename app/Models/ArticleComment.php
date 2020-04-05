<?php

namespace App\Models;

class ArticleComment extends BaseModel {
    protected $fillable = [
        'description',
        'track_article_id',
        'user_id'
    ];

    public function trackArticle() {
        return $this->belongsTo(TrackArticle::class);
    }
}
