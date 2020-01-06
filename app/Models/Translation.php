<?php

namespace App\Models;

class Translation extends BaseModel
{
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru'
    ];
}
