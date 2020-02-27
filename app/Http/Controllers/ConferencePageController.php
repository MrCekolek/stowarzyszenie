<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferencePageRequest;
use App\Models\ConferencePage;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferencePageController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferencePageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/page/get",
     *     tags={"conference_page"},
     *     summary="Gets all conference pages",
     *     operationId="ConferencePageControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Request $request) {
        $input = $request->all();
        $validation = new ConferencePageRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'conferencePages' => ConferencePage::where('id', $input['conference_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/page/create",
     *     tags={"conference_page"},
     *     summary="Creates page for conference",
     *     operationId="ConferencePageControllerCreate",
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
        $validation = new ConferencePageRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferencePage = ConferencePage::addConferencePage($input, $success);

        return LogService::create($success, [
            'conferencePage' => $conferencePage->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/page/update",
     *     tags={"conference_page"},
     *     summary="Updates page for conference",
     *     operationId="ConferencePageControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ConferencePage id",
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
        $validation = new ConferencePageRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferencePage = ConferencePage::updateConferencePage($input, $success);

        return LogService::update($success, [
            'conferencePage' => $conferencePage->load('conference')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/page/destroy",
     *     tags={"conference_page"},
     *     summary="Deletes conference page",
     *     operationId="ConferencePageControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference page id",
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
        $validation = new ConferencePageRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ConferencePage::destroy($input['id']);

        return LogService::delete($success);
    }
}
