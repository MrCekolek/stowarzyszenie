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

    public static function addConferencePage($input, &$success) {
        $conferencePage = new self();
        self::fillConferencePage($conferencePage, $input, $success);

        return $conferencePage;
    }

    public static function updateConferencePage($input, &$success) {
        $conferencePage = self::where('id', $input['id'])->first();
        self::fillConferencePage($conferencePage, $input,$success);

        return $conferencePage;
    }

    private static function fillConferencePage(&$conferencePage, $input, &$success) {
        $conferencePage->name_pl = $input['name_pl'];
        $conferencePage->name_en = $input['name_en'];
        $conferencePage->name_ru = $input['name_ru'];
        $conferencePage->content_pl = $input['content_pl'];
        $conferencePage->content_en = $input['content_en'];
        $conferencePage->content_ru = $input['content_ru'];
        $conferencePage->conference_id = $input['conference_id'];
        $success = $conferencePage->save();
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
