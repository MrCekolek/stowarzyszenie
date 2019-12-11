<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        return LogService::read(true, [
            'roles' => Role::all()->toArray()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) {
        $input = $request->all();
        $validation = new RoleRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $role = Role::create([
            'name' => $input['name']
        ]);

        return LogService::create($role->exists(), [
            'role' => $role->toArray()
        ]);
    }

    /**
     * @param Role $role
     * @return JsonResponse
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
