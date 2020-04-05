<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackChairRequest;
use App\Models\Track;
use App\Models\TrackChair;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class TrackChairController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TrackChairController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/chair/{track}/get",
     *     tags={"track_chair"},
     *     summary="Gets all chairs that belongs to track",
     *     operationId="TrackChairControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Track $track) {
        return LogService::read(true, [
            'trackChairs' => TrackChair::where('track_id', $track->id)->with('user')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/chair/create",
     *     tags={"track_chair"},
     *     summary="Assign chair for track",
     *     operationId="TrackChairControllerCreate",
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
     *         name="track_id",
     *         in="query",
     *         description="Track id",
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
        $validation = new TrackChairRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackChair = new TrackChair();
        $trackChair->user_id = $input['user_id'];
        $trackChair->track_id = $input['track_id'];
        $success = $trackChair->save();

        return LogService::create($success, [
            'trackChair' => $trackChair->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/chair/destroy",
     *     tags={"track_chair"},
     *     summary="Deletes track chair",
     *     operationId="TrackChairControllerDestroy",
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
     *         name="track_id",
     *         in="query",
     *         description="Track id",
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

        $validation = new TrackChairRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TrackChair::where('user_id', $input['user_id'])
            ->where('track_id', $input['track_id'])
            ->delete();

        return LogService::delete($success);
    }
}
