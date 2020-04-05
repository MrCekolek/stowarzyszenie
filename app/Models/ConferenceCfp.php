<?php

namespace App\Models;

class ConferenceCfp extends BaseModel {
    protected $fillable = [
        'file',
        'content_pl',
        'content_en',
        'content_ru',
        'conference_id'
    ];

    public static function addConferenceCfp($input, &$success) {
        $conferenceCfp = new self();
        self::fillConferenceCfp($conferenceCfp, $input, $success);

        return $conferenceCfp;
    }

    public static function updateConferenceCfp($input, &$success) {
        $conferenceCfp = self::where('id', $input['id'])->first();
        self::fillConferenceCfp($conferenceCfp, $input,$success);

        return $conferenceCfp;
    }

    private static function fillConferenceCfp(&$conferenceCfp, $input, &$success) {
        $conferenceCfp->file = $input['file'];
        $conferenceCfp->content_pl = $input['content_pl'];
        $conferenceCfp->content_en = $input['content_en'];
        $conferenceCfp->content_ru = $input['content_ru'];
        $conferenceCfp->conference_id = $input['conference_id'];
        $success = $conferenceCfp->save();
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
