<?php

namespace App\Models;

class TrackArticle extends BaseModel {
    protected $fillable = [
        'title_pl',
        'title_en',
        'title_ru',
        'abstract_pl',
        'abstract_en',
        'abstract_ru',
        'file',
        'track_id'
    ];

    public static function statuses() {
        return [
            'waiting' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.WAITING',
            'review' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.REVIEW',
            'reviewed' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.REVIEWED',
            'accepted' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.ACCEPTED',
            'in pc' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.IN_PROGRAMME_COMMITTEE',
        ];
    }

    public static function addTrackArticle($input, &$success) {
        $trackArticle = new self();
        $trackArticle->status = 'waiting';
        $trackArticle->translation_key = self::statuses()['waiting'];
        self::fillTrackArticle($trackArticle, $input, $success);

        return $trackArticle;
    }

    public static function updateTrackArticle($input, &$success) {
        $trackArticle = self::where('id', $input['id'])->first();
        $trackArticle->status = $input['status'];
        $trackArticle->translation_key = self::statuses()[$input['status']];
        self::fillTrackArticle($trackArticle, $input,$success);

        return $trackArticle;
    }

    private static function fillTrackArticle(&$trackArticle, $input, &$success) {
        $trackArticle->title_pl = $input['title_pl'];
        $trackArticle->title_en = $input['title_en'];
        $trackArticle->title_ru = $input['title_ru'];
        $trackArticle->abstract_pl = $input['abstract_pl'];
        $trackArticle->abstract_en = $input['abstract_en'];
        $trackArticle->abstract_ru = $input['abstract_ru'];
        $trackArticle->file = $input['file'];
        $trackArticle->user_id = $input['user_id'];
        $trackArticle->track_id = $input['track_id'];
        $success = $trackArticle->save();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function track() {
        return $this->belongsTo(Track::class);
    }

    public function articleComments() {
        return $this->hasMany(ArticleComment::class);
    }
}
