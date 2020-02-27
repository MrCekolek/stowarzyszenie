<?php

namespace App\Models;

class Conference extends BaseModel {
    protected $fillable = [
        'status',
        'translation_key',
        'name_pl',
        'name_en',
        'name_ru',
        'content_pl',
        'content_en',
        'content_ru'
    ];

    public static function statuses() {
        return [
            'waiting' => 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.WAITING',
            'during' => 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.DURING',
            'finished' => 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.FINISHED'
        ];
    }

    public static function addConference($input, &$success) {
        $conference = new self();
        self::fillConference($conference, $input, $success);

        return $conference;
    }

    public static function updateConference($input, &$success) {
        $conference = self::where('id', $input['id'])->first();
        self::fillConference($conference, $input,$success);

        return $conference;
    }

    private static function fillConference($conference, $input, &$success) {
        $conference->name_pl = $input['name_pl'];
        $conference->name_en = $input['name_en'];
        $conference->name_ru = $input['name_ru'];
        $conference->content_pl = $input['content_pl'];
        $conference->content_en = $input['content_en'];
        $conference->content_ru = $input['content_ru'];
        $conference->conference_id = $input['conference_id'];
        $success = $conference->save();
    }

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
