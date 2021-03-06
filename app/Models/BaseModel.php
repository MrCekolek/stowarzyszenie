<?php

namespace App\Models;

use App\Traits\Locable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    use Locable;

    public function getUpdatedAtAttribute($value) {
        return $this->localize($value)
            ->toDateTimeString();
    }
}
