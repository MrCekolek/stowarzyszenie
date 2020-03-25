<?php

namespace App\Models;

class ConferencePreference extends BaseModel {
    protected $fillable = [
        'place_pl',
        'place_en',
        'place_ru',
        'website'
    ];

    public static function addConferencePreference($input, $conference, &$success) {
        $conferencePreference = new self();
        self::fillConferencePreference($conferencePreference, $conference, $input, $success);
    }

    public static function updateConferencePreferences($input, $conference, &$success) {
        $conferencePreference = self::where('conference_id', $conference->id)->first();
        self::fillConferencePreference($conferencePreference, $conference, $input, $success);
    }

    public static function fillConferencePreference(&$conferencePreference, $conference, $input, &$success) {
        $conferencePreference->place_pl = $input['place_pl'];
        $conferencePreference->place_en = $input['place_en'];
        $conferencePreference->place_ru = $input['place_ru'];
        $conferencePreference->website = $input['website'];
        $conferencePreference->conference_id = $conference->id;
        $success &= $conferencePreference->save();
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
