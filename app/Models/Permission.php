<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
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
                        'Import',
                        'USERS.IMPORT',
                        PermissionParent::permissionParents()['Users']['id'])
                ]
            ],
            PermissionParent::permissionParents()['Roles']['name'] => [
                [
                    self::definePermission(
                        'Export',
                        'ROLES.EXPORT',
                        PermissionParent::permissionParents()['Roles']['id'])
                ],
                [
                    self::definePermission(
                        'Import',
                        'ROLES.IMPORT',
                        PermissionParent::permissionParents()['Roles']['id'])
                ]
            ]
        ];
    }

    public function permissionParent() {
        return $this->belongsTo(PermissionParent::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->withPivot(['id', 'selected'])
            ->withTimestamps();
    }

    private static function definePermission($name, $translationKey, $permissionParentId) {
        return [
            'name' => $name,
            'translation_key' => $translationKey,
            'permission_parent_id' => $permissionParentId
        ];
    }
}
