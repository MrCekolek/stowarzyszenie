<?php

namespace App\Models;

class Permission extends BaseModel {
    protected $fillable = [
        'name',
        'translation_key',
        'permission_parent_id'
    ];

    // dodatkowe uprawnienia
    public static function permissions() {
        return [
            PermissionParent::permissionParents()['Users']['name'] => [
                [
                    self::definePermission(
                        'Add',
                        'USERS.ADD',
                        PermissionParent::permissionParents()['Users']['id'])
                    ],
                [
                    self::definePermission(
                        'Change role',
                        'USERS.CHANGE_ROLE',
                        PermissionParent::permissionParents()['Users']['id'])
                ],
                [
                    self::definePermission(
                        'Delete',
                        'USERS.DELETE',
                        PermissionParent::permissionParents()['Users']['id'])
                ]
            ],
            PermissionParent::permissionParents()['Roles']['name'] => [
                [
                    self::definePermission(
                        'Add',
                        'ROLES.ADD',
                        PermissionParent::permissionParents()['Roles']['id'])
                    ],
                [
                    self::definePermission(
                        'Change permissions',
                        'ROLES.CHANGE_PERMISSIONS',
                        PermissionParent::permissionParents()['Roles']['id'])
                ],
                [
                    self::definePermission(
                        'Delete',
                        'ROLES.DELETE',
                        PermissionParent::permissionParents()['Roles']['id'])
                ]
            ],
            PermissionParent::permissionParents()['Portfolio']['name'] => [
                    [
                        self::definePermission(
                            'Add tabs',
                            'PORTFOLIO.ADD_TABS',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit tabs',
                            'PORTFOLIO.EDIT_TABS',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete tabs',
                            'PORTFOLIO.DELETE_TABS',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Hide tabs',
                            'PORTFOLIO.HIDE_TABS',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Add cards',
                            'PORTFOLIO.ADD_CARDS',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit cards name',
                            'PORTFOLIO.EDIT_CARD_NAMES',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete card',
                            'PORTFOLIO.DELETE_CARD',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Hide card',
                            'PORTFOLIO.HIDE_CARD',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Add content to card',
                            'PORTFOLIO.ADD_CONTENT',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete content from card',
                            'PORTFOLIO.DELETE_CONTENT',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit content in card',
                            'PORTFOLIO.EDIT_CONTENT',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
                    [
                        self::definePermission(
                            'Hide content in card',
                            'PORTFOLIO.HIDE_CONTENT',
                            PermissionParent::permissionParents()['Portfolio']['id'])
                    ],
            ],
            PermissionParent::permissionParents()['Interests']['name'] => [
                    [
                        self::definePermission(
                            'Add',
                            'INTERESTS.ADD',
                            PermissionParent::permissionParents()['Interests']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit',
                            'INTERESTS.EDIT',
                            PermissionParent::permissionParents()['Interests']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete',
                            'INTERESTS.DELETE',
                            PermissionParent::permissionParents()['Interests']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Home_Navigation']['name'] => [
                    [
                        self::definePermission(
                            'Add pages',
                            'HOME_NAVIGATION.ADD',
                            PermissionParent::permissionParents()['Home_Navigation']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete pages',
                            'HOME_NAVIGATION.DELETE',
                            PermissionParent::permissionParents()['Home_Navigation']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit pages',
                            'HOME_NAVIGATION.EDIT',
                            PermissionParent::permissionParents()['Home_Navigation']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Translations']['name'] => [
                    [
                        self::definePermission(
                            'Add translations',
                            'TRANSLATIONS.ADD',
                            PermissionParent::permissionParents()['Translations']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit translations',
                            'TRANSLATIONS.EDIT',
                            PermissionParent::permissionParents()['Translations']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete translations',
                            'TRANSLATIONS.DELETE',
                            PermissionParent::permissionParents()['Translations']['id'])
                    ],
                    [
                        self::definePermission(
                            'Manage translations',
                            'TRANSLATIONS.MANAGE',
                            PermissionParent::permissionParents()['Translations']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_General']['name'] => [
                    [
                        self::definePermission(
                            'Add conference',
                            'CONFERENCE_GENERAL.ADD_NEW',
                            PermissionParent::permissionParents()['Conference_General']['id'])
                    ],
                    [
                        self::definePermission(
                            'Change status',
                            'CONFERENCE_GENERAL.CHANGE_CONFERENCE_STATUS',
                            PermissionParent::permissionParents()['Conference_General']['id'])
                    ],
                    [
                        self::definePermission(
                            'Register to conference',
                            'CONFERENCE_GENERAL.REGISTER_TO_CONF',
                            PermissionParent::permissionParents()['Conference_General']['id'])
                    ],
                    [
                        self::definePermission(
                            'Change status of payments',
                            'CONFERENCE_GENERAL.CHANGE_PAYMENTS',
                            PermissionParent::permissionParents()['Conference_General']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Tracks']['name'] => [
                    [
                        self::definePermission(
                            'Add track',
                            'CONFERENCE_TRACKS.ADD_NEW',
                            PermissionParent::permissionParents()['Conference_Tracks']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit tracks',
                            'CONFERENCE_TRACKS.EDIT_TRACK',
                            PermissionParent::permissionParents()['Conference_Tracks']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete tracks',
                            'CONFERENCE_TRACKS.DELETE_TRACK',
                            PermissionParent::permissionParents()['Conference_Tracks']['id'])
                    ],
                    [
                        self::definePermission(
                            'Assign chair',
                            'CONFERENCE_TRACKS.ASSIGN_CHAIR',
                            PermissionParent::permissionParents()['Conference_Tracks']['id'])
                    ],
                    [
                        self::definePermission(
                            'Assign reviewers',
                            'CONFERENCE_TRACKS.ASSIGN_REVIEWER',
                            PermissionParent::permissionParents()['Conference_Tracks']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Page']['name'] => [
                    [
                        self::definePermission(
                            'Add page',
                            'CONFERENCE_PAGE.ADD_NEW',
                            PermissionParent::permissionParents()['Conference_Page']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit page',
                            'CONFERENCE_PAGE.EDIT_PAGE',
                            PermissionParent::permissionParents()['Conference_Page']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete page',
                            'CONFERENCE_PAGE.DELETE_PAGE',
                            PermissionParent::permissionParents()['Conference_Page']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Calendar']['name'] => [
                    [
                        self::definePermission(
                            'Add date',
                            'CONFERENCE_CALENDAR.ADD_DATE',
                            PermissionParent::permissionParents()['Conference_Calendar']['id'])
                    ],
                    [
                        self::definePermission(
                            'Edit date',
                            'CONFERENCE_CALENDAR.EDIT_DATE',
                            PermissionParent::permissionParents()['Conference_Calendar']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete date',
                            'CONFERENCE_CALENDAR.DELETE_DATE',
                            PermissionParent::permissionParents()['Conference_Calendar']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Program_committee']['name'] => [
                    [
                        self::definePermission(
                            'Add PC',
                            'PROGRAM_COMMITTEE.ADD_PC',
                            PermissionParent::permissionParents()['Program_committee']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete PC',
                            'PROGRAM_COMMITTEE.DELETE_PC',
                            PermissionParent::permissionParents()['Program_committee']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Gallery']['name'] => [
                    [
                        self::definePermission(
                            'Add picture',
                            'PROGRAM_GALLERY.ADD_PICTURE',
                            PermissionParent::permissionParents()['Conference_Gallery']['id'])
                    ],
                    [
                        self::definePermission(
                            'Delete picture',
                            'PROGRAM_GALLERY.DELETE_PICTURE',
                            PermissionParent::permissionParents()['Conference_Gallery']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Programme']['name'] => [
                    [
                        self::definePermission(
                            'Set programme dates',
                            'CONFERENCE_PROGRAMME.SET_DATES',
                            PermissionParent::permissionParents()['Conference_Programme']['id'])
                    ],
                    [
                        self::definePermission(
                            'Add programme events',
                            'CONFERENCE_PROGRAMME.ADD_EVENTS',
                            PermissionParent::permissionParents()['Conference_Programme']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Articles']['name'] => [
                    [
                        self::definePermission(
                            'Accept sent conference articles',
                            'CONFERENCE_ARTICLES.ACCEPT_ARTICLES',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                    [
                        self::definePermission(
                            'Reject sent conference articles',
                            'CONFERENCE_ARTICLES.REJECT_ARTICLES',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                    [
                        self::definePermission(
                            'Publish articles',
                            'CONFERENCE_ARTICLES.PUBLISH_ARTICLES',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                    [
                        self::definePermission(
                            'Assign reviewers in track',
                            'CONFERENCE_ARTICLES.ASSIGN_REVIEWERS',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                    [
                        self::definePermission(
                            'Add comment for author',
                            'CONFERENCE_ARTICLES.ADD_COMMENT',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                    [
                        self::definePermission(
                            'Restore rejected articles',
                            'CONFERENCE_ARTICLES.RESTORE_ARTICLES',
                            PermissionParent::permissionParents()['Conference_Articles']['id'])
                    ],
                ],
            PermissionParent::permissionParents()['Conference_Reviews']['name'] => [
                    [
                        self::definePermission(
                            'Assign reviewers',
                            'CONFERENCE_REVIEWS.ASSIGN_REVIEWERS',
                            PermissionParent::permissionParents()['Conference_Reviews']['id'])
                    ],
                    [
                        self::definePermission(
                            'Can review',
                            'CONFERENCE_REVIEWS.REVIEWING',
                            PermissionParent::permissionParents()['Conference_Reviews']['id'])
                    ],
                    [
                        self::definePermission(
                            'See review',
                            'CONFERENCE_REVIEWS.SEE_REVIEW',
                            PermissionParent::permissionParents()['Conference_Reviews']['id'])
                    ],
                ],
        ];
    }

    public function permissionParent() {
        return $this->belongsTo(PermissionParent::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->withPivot([
                'id',
                'selected'
            ]);
    }

    private static function definePermission($name, $translationKey, $permissionParentId) {
        return [
            'name' => $name,
            'translation_key' => $translationKey,
            'permission_parent_id' => $permissionParentId
        ];
    }
}
