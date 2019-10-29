<?php

namespace App\Http\Controllers;

use App\Models\PermissionParent;
use App\Models\Role;

class PermissionParentController extends Controller {
    public function rolePermissions(Role $role) {
        $rolePermission = PermissionParent::with(['permissions.roles' => function($roles) use ($role) {
            $roles->whereId($role->id);
        }])->get();

        dd($rolePermission);
    }
}
