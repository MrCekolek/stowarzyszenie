<?php

namespace App\Http\Controllers;

use App\Models\PermissionParent;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Support\Facades\Request;

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
            'role' => $role->name,
            'permissions' => $permissionParents
        ]);
    }

    public function updateRolePermissions(Role $role) {
        $input = request()->all();
        $success = true;

        foreach ($input['permissions'] as $permissionParent) {
            foreach ($permissionParent['permissions'] as $permissions) {
                foreach ($permissions['roles'] as $permissionRole) {
                    $saved = PermissionRole::whereId($permissionRole['pivot']['id'])
                        ->update([
                            'selected' => $permissions['selected']
                        ]);

                    if ($saved === 0) {
                        $success = false;
                    }
                }
            }
        }

        return response()->json([
           'success' => $success
        ]);
    }
}
