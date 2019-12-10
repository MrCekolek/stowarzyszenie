<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TileContent extends Model {
    protected $fillable = [
        'name_en',
        'name_pl',
        'name_ru',
        'type',
        'translation_key',
        'admin_visibility',
        'user_visibility',
        'tile_id'
    ];

    public function tile() {
        return $this->belongsTo(Tile::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }
}
