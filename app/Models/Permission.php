<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'translation_key',
        'permission_id'
    ];

    public function permissionParent() {
        return $this->belongsTo(PermissionParent::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->withPivot('selected')
            ->withTimestamps();
    }
}
