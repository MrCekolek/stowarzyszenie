<?php

namespace App\Models;

use App\Traits\UploadFile;

class ConferenceCfp extends BaseModel {
    use UploadFile;

    protected $fillable = [
        'file_name',
        'file',
        'content_pl',
        'content_en',
        'content_ru',
        'conference_id'
    ];

    public static function addConferenceCfp($request, $input, &$success) {
        $conferenceCfp = new self();
        self::fillConferenceCfp($conferenceCfp, $request, $input, $success);

        return $conferenceCfp;
    }

    public static function updateConferenceCfp($request, $input, &$success) {
        $conferenceCfp = self::where('id', $input['id'])->first();
        self::fillConferenceCfp($conferenceCfp, $request, $input,$success);

        return $conferenceCfp;
    }

    private static function fillConferenceCfp(&$conferenceCfp, $request, $input, &$success) {
        $conferenceCfp->file_name = $input['file_name'];
        $conferenceCfp->file = self::setFile($conferenceCfp, $request);
        $conferenceCfp->content_pl = $input['content_pl'];
        $conferenceCfp->content_en = $input['content_en'];
        $conferenceCfp->content_ru = $input['content_ru'];
        $conferenceCfp->conference_id = $input['conference_id'];
        $success = $conferenceCfp->save();
    }

    private static function setFile($conferenceCfp, $request) {
        if (!$request->hasFile('new_file')) {
            return $conferenceCfp->file;
        }

        $image = $request->file('new_file');
        $name = $image->getClientOriginalName();
        $folder  = '/uploads/files/cfps';

        return config('app.back_url') . '/' . (new ConferenceCfp)->uploadOne($image, $folder, 'public', $name);
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
