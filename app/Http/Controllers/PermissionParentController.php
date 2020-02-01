<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionParentRequest;
use App\Models\PermissionParent;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class PermissionParentController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class PermissionParentController extends Controller {
    /**
     * @OA\Post(
     *     path="/role/{roleId}/permission/get",
     *     tags={"permission"},
     *     summary="Gets role permissions",
     *     operationId="PermissionParentControllerRolePermissions",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Role id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function rolePermissions(Role $role) {
        $validation = new PermissionParentRequest($role->toArray(), 'rolePermissions');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $permissionParents = PermissionParent::with([
            'permissions.roles' => function ($roles) use ($role) {
                return $roles->where('roles.id', $role->id);
            }])->get()->toArray();

        foreach ($permissionParents as &$permissionParent) {
            foreach ($permissionParent['permissions'] as &$permission) {
                $permission['selected'] = (Boolean) implode('', array_map(function ($role) {
                    return $role['pivot']['selected'];
                }, $permission['roles']));
            }
        }

        return LogService::read(true, [
            'role' => $role,
            'permissions' => $permissionParents
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/{roleId}/permission/update",
     *     tags={"permission"},
     *     summary="Updates role permissions",
     *     operationId="PermissionParentControllerUpdateRolePermissions",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Role's id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="permissions",
     *         in="query",
     *         description="Role permissions",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function updateRolePermissions(Request $request, Role $role) {
        $input = $request->all();

        $validation = new PermissionParentRequest($role->toArray(), 'rolePermissions');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = true;

        foreach ($input['permissions'] as $permissionParent) {
            foreach ($permissionParent['permissions'] as $permissions) {
                foreach ($permissions['roles'] as $permissionRole) {
                    $saved = PermissionRole::where('id', $permissionRole['pivot']['id'])
                        ->update([
                            'selected' => $permissions['selected']
                        ]);

                    if ($saved === 0) {
                        $success = false;
                    }
                }
            }
        }

        return LogService::update($success);
    }
}
