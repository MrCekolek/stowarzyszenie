<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestUserRequest;
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
     *     operationId="InterestControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(User $user) {
        return LogService::read(true, [
            'interestUsers' => InterestUser::where('user_id', $user->id)->first()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/user/selected/update",
     *     tags={"interest_user"},
     *     summary="Select specific interest for user",
     *     operationId="InterestControllerIndex",
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
     *     @OA\Parameter(
     *         name="selected",
     *         in="query",
     *         description="Is selected (true or false)",
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
    public function update(Request $request) {
        $input = $request->all();
        $validation = new InterestUserRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $interestUser = InterestUser::where('user_id', $input['user_id'])
            ->where('interest_id', $input['interest_id'])
            ->first();
        $interestUser->selected = $input['selected'];
        $success = $interestUser->save();

        return LogService::update($success);
    }
}
