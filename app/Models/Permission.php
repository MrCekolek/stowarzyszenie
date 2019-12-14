<?php

namespace App\Models;

class Permission extends BaseModel {
    protected $fillable = [
        'name',
        'translation_key',
        'permission_parent_id'
    ];

    // operacje CRUD
    public static function CRUD() {
        return [
            'CREATE',
            'INDEX',
            'EDIT',
            'DELETE'
        ];
    }

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
                ],
            ]
        ];
    }

    public function permissionParent() {
        return $this->belongsTo(PermissionParent::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->withPivot(['id', 'selected']);
    }

    private static function definePermission($name, $translationKey, $permissionParentId) {
        return [
            'name' => $name,
            'translation_key' => $translationKey,
            'permission_parent_id' => $permissionParentId
        ];
    }
}
