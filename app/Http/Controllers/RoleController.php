<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class RoleController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class RoleController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/role/get",
     *     tags={"role"},
     *     summary="Gets all roles",
     *     operationId="RoleControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'roles' => Role::all()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/create",
     *     tags={"role"},
     *     summary="Creates role",
     *     operationId="RoleControllerCreate",
     *     @OA\Parameter(
     *         name="name_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name_ru",
     *         in="query",
     *         description="Translation in russian language",
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
    public function create(Request $request) {
        $input = $request->all();
        $validation = new RoleRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $role = new Role();
        $role->name_pl = $input['name_pl'];
        $role->name_en = $input['name_en'];
        $role->name_ru = $input['name_ru'];
        $success = $role->save();

        return LogService::create($success, [
            'role' => $role->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/{roleId}/update",
     *     tags={"role"},
     *     summary="Updates role",
     *     operationId="RoleControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Role id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name_ru",
     *         in="query",
     *         description="Translation in russian language",
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
    public function update(Request $request, Role $role) {
        $input = $request->all();
        $validation = new RoleRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = $role->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru']
        ]);

        return LogService::update($success > 0, [
            'role' => $role->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/delete/{roleId}",
     *     tags={"role"},
     *     summary="Deletes specific role",
     *     operationId="RoleControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Role's id",
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
    public function destroy(Role $role) {
        $validation = new RoleRequest($role->toArray(), 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Role::destroy($role->id);

        return LogService::delete($success);
    }
}
