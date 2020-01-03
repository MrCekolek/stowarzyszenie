<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru'
    ];
}
