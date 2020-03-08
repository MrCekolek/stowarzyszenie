<?php

namespace App\Models;

class HomeNavigation extends BaseModel
{
    protected $fillable = [
        'status',
        'translation_key',
        'name_pl',
        'name_en',
        'name_ru',
        'link',
        'content_pl',
        'content_en',
        'content_ru',
        'user_id'
    ];

    public static function statuses() {
        return [
            'published' => 'STOWARZYSZENIE.PAGE_STATUS.PUBLISHED',
            'in progress' => 'STOWARZYSZENIE.PAGE_STATUS.IN_PROGRESS',
            'not editable' => 'STOWARZYSZENIE.PAGE_STATUS.NOT_EDITABLE'
        ];
    }

    public static function addHomeNavigation($input, &$success) {
        $homeNavigation = new self();
        self::fillHomeNavigation($homeNavigation, $input, $success);

        return $homeNavigation;
    }

    public static function updateHomeNavigation($input, &$success) {
        $homeNavigation = self::where('id', $input['id'])->first();
        self::fillHomeNavigation($homeNavigation, $input,$success);

        return $homeNavigation;
    }

    public static function fillHomeNavigation($homeNavigation, $input, &$success) {
        $homeNavigation->status = $input['status'];
        $homeNavigation->translation_key = self::statuses()[$input['status']];
        $homeNavigation->name_pl = $input['name_pl'];
        $homeNavigation->name_en = $input['name_en'];
        $homeNavigation->name_ru = $input['name_ru'];
        $homeNavigation->link = $input['link'];
        $homeNavigation->content_pl = $input['content_pl'];
        $homeNavigation->content_en = $input['content_en'];
        $homeNavigation->content_ru = $input['content_ru'];
        $homeNavigation->user_id = $input['user_id'];
        $success = $homeNavigation->save();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
