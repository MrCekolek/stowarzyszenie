<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferenceController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferenceController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/get",
     *     tags={"conference"},
     *     summary="Gets all conferences",
     *     operationId="ConferenceControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'conferences' => Conference::all()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/active/get",
     *     tags={"conference"},
     *     summary="Gets active conference",
     *     operationId="ConferenceControllerGetActive",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getActive() {
        return LogService::read(true, [
            'conferences' => Conference::where('status', 'during')->first()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/create",
     *     tags={"conference"},
     *     summary="Creates conference",
     *     operationId="ConferenceControllerCreate",
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
     *         name="content_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_ru",
     *         in="query",
     *         description="Translation in russian language",
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
        $validation = new ConferenceRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conference = Conference::addConference($input, $success);

        return LogService::create($success, [
            'conference' => $conference->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/update",
     *     tags={"conference"},
     *     summary="Updates conference",
     *     operationId="ConferenceControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference id",
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
     *         name="content_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_ru",
     *         in="query",
     *         description="Translation in russian language",
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
        $validation = new ConferenceRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conference = Conference::updateConference($input, $success);

        return LogService::update($success, [
            'conference' => $conference->load('conference')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/destroy",
     *     tags={"conference"},
     *     summary="Deletes conference",
     *     operationId="ConferenceControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
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
        $validation = new ConferenceRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Conference::destroy($input['id']);

        return LogService::delete($success);
    }
}
