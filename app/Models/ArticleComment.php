<?php

namespace App\Models;

use App\Traits\Locable;
use Carbon\Carbon;

class ArticleComment extends BaseModel {
    use Locable;

    protected $fillable = [
        'description',
        'track_article_id',
        'user_id'
    ];

    protected $appends = [
        'created_at_human_pl',
        'created_at_human_en',
        'created_at_human_ru'
    ];

    public function getCreatedAtHumanPlAttribute() {
        Carbon::setLocale('pl');

        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getCreatedAtHumanEnAttribute() {
        Carbon::setLocale('en');

        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getCreatedAtHumanRuAttribute() {
        Carbon::setLocale('ru');

        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function trackArticle() {
        return $this->belongsTo(TrackArticle::class);
    }
}
