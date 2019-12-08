<?php

namespace App\Models;

class PermissionRole extends BasePivot {
    protected $table = 'permission_role';

    protected $fillable = [
      'permission_id',
      'role_id',
    ];
}
