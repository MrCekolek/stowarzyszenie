<?php

namespace App\Models;

class Conference extends BaseModel {
    protected $fillable = [
        'status',
        'translation_key',
        'acronym',
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
        $conference->status = 'waiting';
        $conference->translation_key = self::statuses()['waiting'];
        self::fillConference($conference, $input, $success);
        ConferencePreference::addConferencePreference($input, $conference, $success);

        return $conference;
    }

    public static function updateConference($input, &$success) {
        $conference = self::where('id', $input['id'])->first();
        $conference->status = $input['status'];
        $conference->translation_key = self::statuses()[$input['status']];
        self::fillConference($conference, $input,$success);
        ConferencePreference::updateConferencePreferences($input, $conference, $success);

        return $conference;
    }

    private static function fillConference(&$conference, $input, &$success) {
        $conference->acronym = $input['acronym'];
        $conference->name_pl = $input['name_pl'];
        $conference->name_en = $input['name_en'];
        $conference->name_ru = $input['name_ru'];
        $conference->content_pl = $input['content_pl'];
        $conference->content_en = $input['content_en'];
        $conference->content_ru = $input['content_ru'];
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

    public function conferencePreference() {
        return $this->hasOne(ConferencePreference::class);
    }

    public function programmeCommittee() {
        return $this->belongsToMany(User::class)
            ->using(ProgrammeCommittee::class);
    }

    public function conferenceEvents() {
        return $this->hasMany(ConferenceEvent::class);
    }

    public function conferenceCfp() {
        return $this->hasOne(ConferenceCfp::class);
    }
}
