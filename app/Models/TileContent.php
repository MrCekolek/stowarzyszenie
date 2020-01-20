<?php

namespace App\Models;

class TileContent extends BaseModel {
    protected $fillable = [
        'shared_id',
        'name_pl',
        'name_en',
        'name_ru',
        'type',
        'translation_key',
        'position',
        'admin_visibility',
        'user_visibility',
        'tile_id',
        'tile_shared_id'
    ];

    public static function types() {
        return [
            'input',
            'textarea',
            'radio',
            'checkbox',
            'select'
        ];
    }

    public static function translations() {
        return [
            self::types()[0] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.INPUT',
            self::types()[1] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.TEXTAREA',
            self::types()[2] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.RADIO',
            self::types()[3] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.CHECKBOX',
            self::types()[4] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.SELECT'
        ];
    }

    public static function addContent($tileContent, $options) {
        $contents = [];
        $sharedId = Content::where('tile_content_id', $tileContent->id)->max('shared_id') + 1;

        if ($tileContent->type === self::types()[0] || $tileContent->type === self::types()[1]) {
            $content = new Content();
            $content->shared_id = $sharedId;
            $content->value_pl = '';
            $content->value_en = '';
            $content->value_ru = '';
            $content->position = Content::where('tile_content_id', $tileContent->id)->max('position') + 1;
            $content->tile_content_id = $tileContent->id;
            $content->tile_content_shared_id = $tileContent->shared_id;
            $content->save();

            $contents[] = $content;
        } else {

            foreach ($options as $option) {
                $content = new Content();
                $content->shared_id = $sharedId;
                $content->value_pl = $option['value_pl'];
                $content->value_en = $option['value_en'];
                $content->value_ru = $option['value_ru'];
                $content->position = Content::where('tile_content_id', $tileContent->id)->max('position') + 1;
                $content->tile_content_id = $tileContent->id;
                $content->tile_content_shared_id = $tileContent->shared_id;
                $content->save();

                $contents[] = $content;
            }
        }

        return $contents;
    }

    public function tile() {
        return $this->belongsTo(Tile::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }
}
