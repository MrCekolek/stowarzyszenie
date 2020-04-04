<?php

namespace App\Models;

class Role extends BaseModel {
    protected $fillable = [
        'name_pl',
        'name_en',
        'name_ru'
    ];

    public static function roles() {
        return [
            'Administrator',
            'User',
            'General Chair',
            'Programme Chair',
            'Programme committee',
            'Track chair',
            'Local chair',
            'Reviewer',
            'Author'
        ];
    }

    public function users() {
        return $this->belongsToMany(User::class)
            ->using(RoleUser::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class)
            ->withPivot('selected')
            ->using(PermissionRole::class);
    }
}
