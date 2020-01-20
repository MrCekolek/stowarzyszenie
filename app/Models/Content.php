<?php

namespace App\Models;

use App\Traits\ChangePosition;

class Content extends BaseModel {
    use ChangePosition;

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

    public static function addContent($input, &$success) {
        $content = new self();
        $content->shared_id = self::where('tile_content_shared_id')->max('shared_id') + 1;
        $content->value_pl = $input['value_pl'];
        $content->value_en = $input['value_en'];
        $content->value_ru = $input['value_ru'];
        $content->selected = $input['selected'];
        $content->position = self::where('tile_content_shared_id')->max('position') + 1;
        $content->tile_content_id = $input['tile_content_id'];
        $content->tile_content_shared_id = $input['tile_content_shared_id'];
        $success = $content->save();

        return $content;
    }

    public static function updateContent($content, $input, &$success) {
        $content->name_pl = $input['name_pl'];
        $content->name_en = $input['name_en'];
        $content->name_ru = $input['name_ru'];

        if ($content->isDity('position')) {
            self::changePosition(__CLASS__, $content, $input['position']);
        }

        $content->admin_visibility = $input['admin_visibility'];
        $content->user_visibility = $input['user_visibility'];
        $success &= $content->save();
    }
}
