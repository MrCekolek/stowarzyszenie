<?php

namespace App\Models;

class Content extends BaseModel {
    protected $fillable = [
        'shared_id',
        'value_pl',
        'value_en',
        'value_ru',
        'selected',
        'position',
        'admin_visibility',
        'user_visibility',
        'tile_content_id',
        'tile_content_shared_id'
    ];

    public function tileContent() {
        return $this->belongsTo(TileContent::class);
    }
}
