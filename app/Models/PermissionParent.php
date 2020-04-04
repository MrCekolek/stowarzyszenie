<?php

namespace App\Models;

class PermissionParent extends BaseModel {
    protected $fillable = [
        'name',
        'translation_key'
    ];

    // kategorie uprawnien
    public static function permissionParents() {
        return [
            'Users' => [
                'id' => 1,
                'name' => 'Users',
                'translation_key' => 'USERS.USERS'
            ],
            'Roles' => [
                'id' => 2,
                'name' => 'Roles',
                'translation_key' => 'ROLES.ROLES'
            ],
            'Portfolio' => [
                'id' => 3,
                'name' => 'Portfolio',
                'translation_key' => 'PORTFOLIO.PORTFOLIO'
            ],
            'Interests' => [
                'id' => 4,
                'name' => 'Interests',
                'translation_key' => 'INTERESTS.INTERESTS'
            ],
            'Home_Navigation' => [
                'id' => 5,
                'name' => 'Home_Navigation',
                'translation_key' => 'HOME_NAVIGATION.NAVIGATION'
            ],
            'Translations' => [
                'id' => 6,
                'name' => 'Translations',
                'translation_key' => 'TRANSLATIONS.TRANSLATIONS'
            ],
            'Conference_General' => [
                'id' => 7,
                'name' => 'Conference_General',
                'translation_key' => 'CONFERENCE_GENERAL.GENERAL'
            ],
            'Conference_Tracks' => [
                'id' => 8,
                'name' => 'Conference_Tracks',
                'translation_key' => 'CONFERENCE_TRACKS.TRACKS'
            ],
            'Conference_Page' => [
                'id' => 9,
                'name' => 'Conference_Page',
                'translation_key' => 'CONFERENCE_PAGE.PAGE'
            ],
            'Conference_Calendar' => [
                'id' => 10,
                'name' => 'Conference_Calendar',
                'translation_key' => 'CONFERENCE_CALENDAR.CALENDAR'
            ],
            'Program_committee' => [
                'id' => 11,
                'name' => 'Program_committee',
                'translation_key' => 'PROGRAM_COMMITTEE.COMMITTEE'
            ],
            'Conference_Gallery' => [
                'id' => 12,
                'name' => 'Conference_Gallery',
                'translation_key' => 'CONFERENCE_GALLERY.GALLERY'
            ],
            'Conference_Programme' => [
                'id' => 13,
                'name' => 'Conference_Programme',
                'translation_key' => 'CONFERENCE_PROGRAMME.PROGRAMME'
            ],
            'Conference_Articles' => [
                'id' => 14,
                'name' => 'Conference_Articles',
                'translation_key' => 'CONFERENCE_ARTICLES.ARTICLES'
            ],
            'Conference_Reviews' => [
                'id' => 15,
                'name' => 'Conference_Reviews',
                'translation_key' => 'CONFERENCE_REVIEWS.REVIEWS'
            ],
        ];
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
