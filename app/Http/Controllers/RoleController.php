<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        return response()->json([
           'roles' => Role::all()
        ]);
    }

    /**
     * @param RoleRequest $roleRequest
     *
     * @return JsonResponse
     */
    public function create(RoleRequest $roleRequest) {
        $input = $roleRequest->all();

        $role = Role::create([
            'name' => $input['name']
        ]);

        return response()->json([
            'success' => $role->exists(),
            'role' => $role
        ]);
    }
}
