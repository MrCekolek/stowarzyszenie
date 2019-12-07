<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliationUser extends Model {
    protected $fillable = [
        'title',
        'institution',
        'department',
        'street',
        'city',
        'country',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
