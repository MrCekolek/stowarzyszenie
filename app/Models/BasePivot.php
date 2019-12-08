<?php

namespace App\Models;

use App\Traits\Locable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BasePivot extends Pivot {
    use Locable;

    protected $appends = [
        'created_at',
        'updated_at',
    ];

    public function getCreatedAtAttribute($value) {
        return $this->localize($value)->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value) {
        return $this->localize($value)->toDateTimeString();
    }
}
