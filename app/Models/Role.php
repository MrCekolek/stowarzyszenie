<?php

namespace App\Models;

class Role extends BaseModel {
    protected $fillable = [
        'name'
    ];

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
