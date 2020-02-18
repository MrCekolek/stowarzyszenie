<?php

namespace App\Models;

class HomeNavigation extends BaseModel
{
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru',
        'link',
        'content_pl',
        'content_en',
        'content_ru'
    ];
}
