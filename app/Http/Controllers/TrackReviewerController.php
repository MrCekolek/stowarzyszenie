<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackReviewerRequest;
use App\Models\Track;
use App\Models\TrackReviewer;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class TrackReviewerController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TrackReviewerController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/reviewer/{track}/get",
     *     tags={"track_reviewer"},
     *     summary="Gets all reviewers that belongs to track",
     *     operationId="TrackReviewerControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Track $track) {
        return LogService::read(true, [
            'trackReviewers' => TrackReviewer::where('track_id', $track->id)->with('user')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/reviewer/create",
     *     tags={"track_reviewer"},
     *     summary="Assign reviewer for track",
     *     operationId="TrackReviewerControllerCreate",
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
        $validation = new TrackReviewerRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackReviewer = new TrackReviewer();
        $trackReviewer->user_id = $input['user_id'];
        $trackReviewer->track_id = $input['track_id'];
        $success = $trackReviewer->save();

        return LogService::create($success, [
            'trackReviewer' => $trackReviewer->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/reviewer/destroy",
     *     tags={"track_reviewer"},
     *     summary="Deletes track reviewer",
     *     operationId="TrackReviewerControllerDestroy",
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

        $validation = new TrackReviewerRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TrackReviewer::where('user_id', $input['user_id'])
            ->where('track_id', $input['track_id'])
            ->delete();

        return LogService::delete($success);
    }
}
