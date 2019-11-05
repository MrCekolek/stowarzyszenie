<?php

namespace App\Http\Controllers;

use App\Models\PermissionParent;
use App\Models\Role;
use phpDocumentor\Reflection\Types\Boolean;

class PermissionParentController extends Controller {
    public function rolePermissions(Role $role) {
        $permissionParents = PermissionParent::with(['permissions.roles' => function ($roles) use ($role) {
            return $roles->where('roles.id', $role->id);
        }])->get()->toArray();

        foreach ($permissionParents as &$permissionParent) {
            foreach ($permissionParent['permissions'] as &$permission) {
                $permission['selected'] = (Boolean) implode('', array_map(function ($role) {
                    return $role['pivot']['selected'];
                }, $permission['roles']));
            }
        }

        return response()->json([
            'permissions' => $permissionParents
        ]);
    }
}
