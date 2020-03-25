<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackRequest;
use App\Models\Track;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class TrackController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TrackController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/get",
     *     tags={"conference_track"},
     *     summary="Gets all conference tracks",
     *     operationId="TrackControllerIndex",
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
    public function index(Request $request) {
        $input = $request->all();
        $validation = new TrackRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'tracks' => Track::where('conference_id', $input['conference_id'])->with('interest')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/create",
     *     tags={"conference_track"},
     *     summary="Creates track for conference",
     *     operationId="TrackControllerCreate",
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
        $validation = new TrackRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $track = new Track();
        $track->name_pl = $input['name_pl'];
        $track->name_en = $input['name_en'];
        $track->name_ru = $input['name_ru'];
        $track->interest_id = $input['interest_id'];
        $track->conference_id = $input['conference_id'];
        $success = $track->save();

        return LogService::create($success, [
            'track' => $track->load('interest')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/update",
     *     tags={"conference_track"},
     *     summary="Update track for conference",
     *     operationId="TrackControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Track id",
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
    public function update(Request $request) {
        $input = $request->all();
        $validation = new TrackRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $track = Track::where('id', $input['id'])->first();
        $track->name_pl = $input['name_pl'];
        $track->name_en = $input['name_en'];
        $track->name_ru = $input['name_ru'];
        $track->interest_id = $input['interest_id'];
        $track->conference_id = $input['conference_id'];
        $success = $track->save();

        return LogService::update($success, [
            'track' => $track->load('interest')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/destroy",
     *     tags={"conference_track"},
     *     summary="Deletes conference track",
     *     operationId="TrackControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference track id",
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
        $validation = new TrackRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Track::destroy($input['id']);

        return LogService::delete($success);
    }
}
