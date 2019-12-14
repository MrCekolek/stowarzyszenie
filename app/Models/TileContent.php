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

    public static function translations() {
        return [
            'input' => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.INPUT',
            'textarea' => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.TEXTAREA',
            'radio' => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.RADIO',
            'checkbox' => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.CHECKBOX',
            'select' => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.SELECT',
        ];
    }

    public function tile() {
        return $this->belongsTo(Tile::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }
}
