<?php

namespace App\Models;

use App\Traits\ChangePosition;

class TileContent extends BaseModel {
    use ChangePosition;

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
            'input' => 'input',
            'textarea' => 'textarea',
            'radio' => 'radio',
            'checkbox' => 'checkbox',
            'select' => 'select'
        ];
    }

    public static function translations() {
        return [
            self::types()['input'] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.INPUT',
            self::types()['textarea'] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.TEXTAREA',
            self::types()['radio'] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.RADIO',
            self::types()['checkbox'] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.CHECKBOX',
            self::types()['select'] => 'STOWARZYSZENIE.SERVER.CUSTOM.TRANSLATIONS.TYPES.SELECT'
        ];
    }

    public static function addTileContent($input, &$success) {
        $tileContent = new self();
        $tileContent->shared_id = self::max('shared_id') + 1;
        $tileContent->name_pl = $input['name_pl'];
        $tileContent->name_en = $input['name_en'];
        $tileContent->name_ru = $input['name_ru'];
        $tileContent->type = $input['type'];
        $tileContent->translation_key = self::translations()[$input['type']];
        $tileContent->position = self::where('tile_shared_id', $input['tile_shared_id'])->max('position') + 1;
        $tileContent->admin_visibility = $input['admin_visibility'];
        $tileContent->user_visibility = $input['user_visibility'];
        $tileContent->tile_id = $input['tile_id'];
        $tileContent->tile_shared_id = $input['tile_shared_id'];
        $success = $tileContent->save();

        return $tileContent;
    }

    public static function updateTileContent($tileContent, $input, &$success) {
        $tileContent->name_pl = $input['name_pl'];
        $tileContent->name_en = $input['name_en'];
        $tileContent->name_ru = $input['name_ru'];
        $tileContent->type = $input['type'];
        $tileContent->translation_key = self::translations()[$input['type']];

        if ($tileContent->isDirty('position')) {
            self::changePosition(self::class, $tileContent, $input['position']);
        }

        $tileContent->admin_visibility = $input['admin_visibility'];
        $tileContent->user_visibility = $input['user_visibility'];
        $success &= $tileContent->save();

        if ($success) {
            $contents = self::updateContent($input['options']);
        }
    }

    public static function addContent($tileContent, $options) {
        $contents = [];
        $sharedId = Content::max('shared_id') + 1;

        if ($tileContent->type === self::types()['input'] || $tileContent->type === self::types()['textarea']) {
            $content = new Content();
            $content->shared_id = $sharedId;
            $content->value_pl = '';
            $content->value_en = '';
            $content->value_ru = '';
            $content->filled_pl = '';
            $content->filled_en = '';
            $content->filled_ru = '';
            $content->position = Content::where('tile_content_shared_id', $tileContent->id)->max('position') + 1;
            $content->tile_content_id = $tileContent->id;
            $content->tile_content_shared_id = $tileContent->shared_id;
            $content->save();

            $contents[] = $content->toArray();
        } else {
            foreach ($options as $option) {
                $content = new Content();
                $content->shared_id = $sharedId;
                $content->value_pl = $option['value_pl'];
                $content->value_en = $option['value_en'];
                $content->value_ru = $option['value_ru'];
                $content->position = Content::where('tile_content_shared_id', $tileContent->id)->max('position') + 1;
                $content->tile_content_id = $tileContent->id;
                $content->tile_content_shared_id = $tileContent->shared_id;
                $content->save();

                $contents[] = $content->toArray();
            }
        }

        return $contents;
    }
    
    public static function updateContent($options) {
        foreach ($options as $option) {
            $content = self::where('id', $option['id']);
            $content->value_pl = $option['value_pl'];
            $content->value_en = $option['value_en'];
            $content->value_ru = $option['value_ru'];
            $content->selected = $option['selected'];

            if ($content->isDity('position')) {
                self::changePosition(Content::class, $content, $option['position']);
            }

            $content->admin_visibility = $option['admin_visibility'];
            $content->user_visibility = $option['user_visibility'];
            $content->save();
        }
    }

    public function tile() {
        return $this->belongsTo(Tile::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }
}
