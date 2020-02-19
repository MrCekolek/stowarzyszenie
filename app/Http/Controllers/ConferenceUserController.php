<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceUserRequest;
use App\Models\ConferenceUser;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferenceUserController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferenceUserController extends Controller {
    /**
     * @OA\Post(
     *     path="/conference/user/create",
     *     tags={"conference_user"},
     *     summary="Registers users to conference",
     *     operationId="ConferenceUserControllerCreate",
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
     *         name="conference_id",
     *         in="query",
     *         description="Conference id",
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
        $validation = new ConferenceUserRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceUser = new ConferenceUser();
        $conferenceUser->user_id = $input['user_id'];
        $conferenceUser->conference_id = $input['conference_id'];
        $success = $conferenceUser->save();

        return LogService::create($success);
    }

    /**
     * @OA\Post(
     *     path="/conference/user/update",
     *     tags={"conference_user"},
     *     summary="Updates registration user to conference",
     *     operationId="ConferenceUserControllerUpdate",
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
     *         name="conference_id",
     *         in="query",
     *         description="Conference id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status",
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
        $validation = new ConferenceUserRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceUser = ConferenceUser::where('user_id', $input['user_id'])
            ->where('conference_id', $input['conference_id'])
            ->first();
        $conferenceUser->status = $input['status'];
        $success = $conferenceUser->save();

        return LogService::create($success);
    }

    /**
     * @OA\Post(
     *     path="/conference/user/destroy",
     *     tags={"conference_user"},
     *     summary="Removes users from conference",
     *     operationId="ConferenceUserControllerUpdate",
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
     *         name="conference_id",
     *         in="query",
     *         description="Conference id",
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
        $validation = new ConferenceUserRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ConferenceUser::where('user_id', $input['user_id'])
            ->where('conference_id', $input['conference_id'])
            ->delete();

        return LogService::update($success);
    }
}
