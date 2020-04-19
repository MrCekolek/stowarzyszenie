<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceGalleryRequest;
use App\Models\ConferenceGallery;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferenceGalleryController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferenceGalleryController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/gallery/get",
     *     tags={"conference_gallery"},
     *     summary="Gets all conference galleries",
     *     operationId="ConferenceGalleryControllerIndex",
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
        $validation = new ConferenceGalleryRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'conferenceGalleries' => ConferenceGallery::where('id', $input['conference_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/gallery/create",
     *     tags={"conference_gallery"},
     *     summary="Creates gallery for conference",
     *     operationId="ConferenceGalleryControllerCreate",
     *     @OA\Parameter(
     *         name="file",
     *         in="query",
     *         description="File",
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
        $validation = new ConferenceGalleryRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        dd($input);

        $conferenceGallery = new ConferenceGallery();
        $conferenceGallery->file = $input['file'];
        $conferenceGallery->conference_id = $input['conference_id'];
        $success = $conferenceGallery->save();

        return LogService::create($success, [
            'conferenceGallery' => $conferenceGallery->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/gallery/destroy",
     *     tags={"conference_gallery"},
     *     summary="Deletes conference gallery",
     *     operationId="ConferenceGalleryControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference gallery id",
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
        $validation = new ConferenceGalleryRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ConferenceGallery::destroy($input['id']);

        return LogService::delete($success);
    }
}
