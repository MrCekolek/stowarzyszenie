<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionParent extends Model {
    protected $fillable = [
        'name',
        'translation_key'
    ];

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
