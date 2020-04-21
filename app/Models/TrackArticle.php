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
        'file_name',
        'file',
        'status',
        'keywords_pl',
        'keywords_en',
        'keywords_ru',
        'translation_key',
        'user_id',
        'track_id'
    ];

    public static function statuses() {
        return [
            'waiting' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.WAITING',
            'review' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.REVIEW',
            'reviewed' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.REVIEWED',
            'accepted' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.ACCEPTED',
            'in pc' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.IN_PROGRAMME',
            'rejected' => 'STOWARZYSZENIE.MODULES.CONFERENCE.TRACK.ARTICLE.STATUS.REJECTED'
        ];
    }

    public static function addTrackArticle($request, $input, &$success) {
        $trackArticle = new self();
        $trackArticle->status = 'waiting';
        $trackArticle->translation_key = self::statuses()['waiting'];
        self::fillTrackArticle($trackArticle, $request, $input, $success);

        return $trackArticle;
    }

    public static function updateTrackArticle($request, $input, &$success) {
        $trackArticle = self::where('id', $input['id'])->first();
        $trackArticle->status = $input['status'];
        $trackArticle->translation_key = self::statuses()[$input['status']];
        self::fillTrackArticle($trackArticle, $request, $input,$success);

        return $trackArticle;
    }

    private static function fillTrackArticle(&$trackArticle, $request, $input, &$success) {
        $trackArticle->title_pl = $input['title_pl'];
        $trackArticle->title_en = $input['title_en'];
        $trackArticle->title_ru = $input['title_ru'];
        $trackArticle->abstract_pl = $input['abstract_pl'];
        $trackArticle->abstract_en = $input['abstract_en'];
        $trackArticle->abstract_ru = $input['abstract_ru'];
        $trackArticle->file_name = $input['file_name'];
        $trackArticle->file = self::setFile($trackArticle, $request);
        $trackArticle->keywords_pl = $input['keywords_pl'];
        $trackArticle->keywords_en = $input['keywords_en'];
        $trackArticle->keywords_ru = $input['keywords_ru'];
        $trackArticle->user_id = $input['user_id'];
        $trackArticle->track_id = $input['track_id'];
        $success = $trackArticle->save();
    }

    private static function setFile($trackArticle, $request) {
        if (!$request->hasFile('new_file')) {
            return $trackArticle->file;
        }

        $image = $request->file('new_file');
        $name = $image->getClientOriginalName();
        $folder  = '/uploads/files/articles';

        return config('app.back_url') . '/' . (new ConferenceCfp)->uploadOne($image, $folder, 'public', $name);
    }

    public function getKeywordsPlAttribute($value) {
        return explode(',', $value);
    }

    public function setKeywordsPlAttribute($value) {
        $this->attributes['keywords_pl'] = str_replace(' ', '', $value);
    }

    public function getKeywordsEnAttribute($value) {
        return explode(',', $value);
    }

    public function setKeywordsEnAttribute($value) {
        $this->attributes['keywords_en'] = str_replace(' ', '', $value);
    }

    public function getKeywordsRuAttribute($value) {
        return explode(',', $value);
    }

    public function setKeywordsRuAttribute($value) {
        $this->attributes['keywords_ru'] = str_replace(' ', '', $value);
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
