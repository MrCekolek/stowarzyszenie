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
            ]
        ];
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
