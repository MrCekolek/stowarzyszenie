<?php

namespace App\Models;

class ProgrammeCommittee extends BasePivot {
    protected $table = 'programme_committee';

    protected $fillable = [
        'user_id',
        'conference_id',
        'contact_email'
    ];
}
