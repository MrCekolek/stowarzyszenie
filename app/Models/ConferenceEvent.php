<?php

namespace App\Models;

use DateTime;

class ConferenceEvent extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru',
        'datetime',
        'end',
        'colour',
        'description_pl',
        'description_en',
        'description_ru',
        'conference_id'
    ];

    protected $appends = [
        'hour',
        'end_hour'
    ];

    public function getDateAttribute() {
        return $this->attributes['datetime'] === null ? null : date('n/j/Y', strtotime($this->attributes['datetime']));
    }

    public function getHourAttribute() {
        return $this->attributes['datetime'] === null ? null : date('H:i', strtotime($this->attributes['datetime']));
    }

    public function getEndHourAttribute() {
        return $this->attributes['end'] === null ? null : date('H:i', strtotime($this->attributes['end']));
    }

    public static function addConferenceEvent($input, &$success) {
        $conferenceEvent = new self();
        $conferenceEvent->datetime = self::formatDate($input, 'datetime', 'hour', false, '', $conferenceEvent);
        $conferenceEvent->end = self::formatDate($input, 'end', 'end_hour', false, '', $conferenceEvent);

        self::fillConferenceEvent($conferenceEvent, $input, $success);

        return $conferenceEvent;
    }

    public static function updateConferenceEvent($input, &$success) {
        $conferenceEvent = self::where('id', $input['id'])->first();
        $conferenceEvent->datetime = self::formatDate($input, 'datetime', 'hour', true, 'date_changed', $conferenceEvent, isset($input['calendar']));
        $conferenceEvent->end = self::formatDate($input, 'end', 'end_hour', true, 'date_changed_end', $conferenceEvent, isset($input['calendar']));

        self::fillConferenceEvent($conferenceEvent, $input,$success);

        return $conferenceEvent;
    }

    private static function fillConferenceEvent(&$conferenceEvent, $input, &$success) {
        $conferenceEvent->name_pl = $input['name_pl'];
        $conferenceEvent->name_en = $input['name_en'];
        $conferenceEvent->name_ru = $input['name_ru'];
        $conferenceEvent->colour = $input['colour'];
        $conferenceEvent->description_pl = $input['description_pl'];
        $conferenceEvent->description_en = $input['description_en'];
        $conferenceEvent->description_ru = $input['description_ru'];
        $conferenceEvent->conference_id = $input['conference_id'];
        $success = $conferenceEvent->save();
    }

    private static function formatDate($input, $dateTime, $hour, $update, $change, $conferenceEvent, $calendar = false) {
        if (empty($input[$dateTime])) {
            return null;
        }

        if ($update && !$calendar) {
            $date = new DateTime(date('Y-m-d H:i:s', (!$input[$change] ? strtotime($conferenceEvent{$dateTime}) : strtotime('+1 day', strtotime($input[$dateTime])))));
        } else {
            $date = new DateTime($input[$dateTime]);
        }

        if (!empty($input[$hour])) {
            $time = explode(':', $input[$hour]);
            $date->setTime($time[0], $time[1]);
        }

        return $date->format('Y-m-d H:i:s');
    }

    public function conference() {
        return $this->belongsTo(Conference::class);
    }
}
