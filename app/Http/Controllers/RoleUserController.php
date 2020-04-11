<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleUserRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Track;
use App\Models\TrackChair;
use App\Models\TrackReviewer;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class RoleUserController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class RoleUserController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/role/{roleId}/users",
     *     tags={"role_user"},
     *     summary="Gets all users that belongs to specific role",
     *     operationId="RoleUserControllerGetUsers",
     *     @OA\Parameter(
     *         name="role_id",
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
    public function getUsers(Request $request, Role $role) {
        $input = $request->all();
        $validation = new RoleUserRequest($input, 'getUsers');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'users' => $role->users()->with(['preferenceUser', 'affilationUser', 'interests', 'roles'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/{roleId}/users/track/not",
     *     tags={"role_user"},
     *     summary="Gets all users that belongs to specific role and doesnt belong to track as chair or reviewer",
     *     operationId="RoleUserControllerGetUsers",
     *     @OA\Parameter(
     *         name="role_id",
     *         in="query",
     *         description="Role id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="track_id",
     *         in="query",
     *         description="Track id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="track_type",
     *         in="query",
     *         description="Track Type",
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
    public function getUsersNotInTrack(Request $request, Role $role, Track $track) {
        $input = $request->all();
        $validation = new RoleUserRequest($input, 'getUsersNotInTrack');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackModel = $input['track_type'] === 'chair' ? TrackChair::class : TrackReviewer::class;

        $usersTrack = $trackModel::where('track_id', $track->id)->get()->pluck('user_id')->toArray();

        return LogService::read(true, [
            'users' => $role->users()->whereNotIn('users.id', $usersTrack)->with(['preferenceUser', 'affilationUser', 'interests', 'roles'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/{roleId}/users/not",
     *     tags={"role_user"},
     *     summary="Gets all users that dont belongs to specific role",
     *     operationId="RoleUserControllerGetUsers",
     *     @OA\Parameter(
     *         name="role_id",
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
    public function getUsersNot(Request $request, Role $role) {
        $input = $request->all();
        $validation = new RoleUserRequest($input, 'getUsersNot');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'users' => User::whereDoesntHave('roles', function (Builder $query) use ($role) {
                $query->where('role_id', '=', $role->id);
            })->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/user/{userId}/roles",
     *     tags={"role_user"},
     *     summary="Gets all roles that belongs to specific user",
     *     operationId="RoleUserControllerGetRoles",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
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
    public function getRoles(Request $request, User $user) {
        $input = $request->all();
        $validation = new RoleUserRequest($input, 'getRoles');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'roles' => $user->roles()->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/user/{userId}/roles/other",
     *     tags={"role_user"},
     *     summary="Gets other roles that doesnt belongs to specific user",
     *     operationId="RoleUserControllerGetOtherRoles",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
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
    public function getOtherRoles(Request $request) {
        $input = $request->all();
        $validation = new RoleUserRequest($input, 'getOtherRoles');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'roles' => Role::whereNotIn('id', User::where('id', $input['user_id'])->first()->roles()->get()->pluck('pivot.role_id')->toArray())->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/role/{role}/user/{user}/create",
     *     tags={"role_user"},
     *     summary="Assigns user to role",
     *     operationId="RoleUserControllerCreate",
     *     @OA\Parameter(
     *         name="role_id",
     *         in="query",
     *         description="Role's id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User's id",
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
    public function create(Request $request, Role $role, User $user) {
        $input = $request->all();

        $validation = new RoleUserRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $roleUser = new RoleUser();
        $roleUser->role_id = $role->id;
        $roleUser->user_id = $user->id;
        $success = $roleUser->save();

        return LogService::create($success);
    }

    /**
     * @OA\Post(
     *     path="/role/{role}/user/{user}/create/multi",
     *     tags={"role_user"},
     *     summary="Assigns roles to user",
     *     operationId="RoleUserControllerCreateMulti",
     *     @OA\Parameter(
     *         name="roles",
     *         in="query",
     *         description="Roles",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User's id",
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
    public function createMulti(Request $request) {
        $input = $request->all();
        $success = true;
        $validation = new RoleUserRequest($input, 'createMulti');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        RoleUser::where('user_id', $input['user_id'])->delete();

        foreach ($input['roles'] as $role) {
            $roleUser = new RoleUser();
            $roleUser->role_id = $role['id'];
            $roleUser->user_id = $input['user_id'];
            $success &= $roleUser->save();
        }

        return LogService::create($success);
    }

    /**
     * @OA\Post(
     *     path="/role/{role}/user/{user}/delete",
     *     tags={"role_user"},
     *     summary="Removes user from role",
     *     operationId="RoleUserControllerDestroy",
     *     @OA\Parameter(
     *         name="role_id",
     *         in="query",
     *         description="Role's id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User's id",
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
    public function destroy(Request $request, Role $role, User $user) {
        $input = $request->all();

        $validation = new RoleUserRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = RoleUser::where('user_id', $user->id)
            ->where('role_id', $role->id)
            ->delete();

        return LogService::delete($success);
    }
}
