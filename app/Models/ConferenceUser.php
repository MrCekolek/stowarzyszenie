<?php

namespace App\Models;

class ConferenceUser extends BasePivot {
    protected $table = 'conference_user';

    protected $fillable = [
        'conference_id',
        'user_id',
        'status',
        'translation_key'
    ];

    public static function statuses() {
        return [
              'paid' => 'STOWARZYSZENIE.MODULES.CONFERENCE_USER.STATUS.PAID',
              'unpaid' => 'STOWARZYSZENIE.MODULES.CONFERENCE_USER.STATUS.UNPAID'
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
