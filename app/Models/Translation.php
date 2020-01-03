<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru'
    ];
}
