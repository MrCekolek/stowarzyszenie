<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestUserRequest;
use App\Models\Interest;
use App\Models\InterestUser;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class InterestUserController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class InterestUserController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/interest/user/{userId}/get",
     *     tags={"interest_user"},
     *     summary="Gets all interests that belongs to user",
     *     operationId="InterestUserControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(User $user) {
        return LogService::read(true, [
            'interests' => Interest::with('users')->get()->toArray(),
            'interestUsers' => InterestUser::where('user_id', $user->id)->with('interest')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/user/create",
     *     tags={"interest_user"},
     *     summary="Assign interest for user",
     *     operationId="InterestUserControllerCreate",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="interest_id",
     *         in="query",
     *         description="Interest id",
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
        $validation = new InterestUserRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $interestUser = new InterestUser();
        $interestUser->user_id = $input['user_id'];
        $interestUser->interest_id = $input['interest_id'];
        $success = $interestUser->save();

        return LogService::create($success, [
            'interestUser' => $interestUser->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/user/destroy",
     *     tags={"interest_user"},
     *     summary="Deletes specific role",
     *     operationId="InterestUserControllerDestroy",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="interest_id",
     *         in="query",
     *         description="Interest id",
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
    public function destroy(Request $request) {
        $input = $request->all();

        $validation = new InterestUserRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = InterestUser::where('user_id', $input['user_id'])
            ->where('interest_id', $input['interest_id'])
            ->delete();

        return LogService::delete($success);
    }
}
