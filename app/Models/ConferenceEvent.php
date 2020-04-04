<?php

namespace App\Models;

class ConferenceEvent extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru',
        'date',
        'colour',
        'description_pl',
        'description_en',
        'description_ru',
        'conference_id'
    ];

    public static function addConferenceEvent($input, &$success) {
        $conferenceEvent = new self();
        self::fillConferenceEvent($conferenceEvent, $input, $success);

        return $conferenceEvent;
    }

    public static function updateConferenceEvent($input, &$success) {
        $conferenceEvent = self::where('id', $input['id'])->first();
        self::fillConferenceEvent($conferenceEvent, $input,$success);

        return $conferenceEvent;
    }

    private static function fillConferenceEvent(&$conferenceEvent, $input, &$success) {
        $conferenceEvent->name_pl = $input['name_pl'];
        $conferenceEvent->name_en = $input['name_en'];
        $conferenceEvent->name_ru = $input['name_ru'];
        $conferenceEvent->date = $input['date'];
        $conferenceEvent->colour = $input['colour'];
        $conferenceEvent->description_pl = $input['description_pl'];
        $conferenceEvent->description_en = $input['description_en'];
        $conferenceEvent->description_ru = $input['description_ru'];
        $conferenceEvent->conference_id = $input['conference_id'];
        $success = $conferenceEvent->save();
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
