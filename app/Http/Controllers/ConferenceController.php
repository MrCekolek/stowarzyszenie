<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;
use App\Models\TrackArticle;
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
        $this->middleware('auth:api', ['except' => ['index', 'show', 'getActive']]);
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
            'conferences' => Conference::with(['conferencePages', 'conferencePreference', 'programmeCommittee', 'conferenceEvents', 'conferenceCfp'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/{conferenceId}",
     *     tags={"conference"},
     *     summary="Gets specfic conference",
     *     operationId="ConferenceControllerShow",
     *      @OA\Parameter(
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
    public function show(Request $request, Conference $conference) {
        $input = $request->all();
        $validation = new ConferenceRequest($input, 'show');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'conferences' => $conference->load(['conferencePages', 'conferencePreference', 'programmeCommittee', 'conferenceEvents', 'conferenceCfp'])->toArray()
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
        $conference = Conference::with(['conferencePages', 'conferencePreference', 'programmeCommittee.preferenceUser', 'programmeCommittee.affilationUser', 'conferenceEvents', 'conferenceCfp', 'conferenceGalleries', 'tracks.interest', 'tracks.trackChairs.preferenceUser'])->where('status', '!=', 'finished')->first();

        return LogService::read(true, [
            'conference' => !empty($conference) ? $conference->toArray() : []
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/article/get",
     *     tags={"conference"},
     *     summary="Gets all conference articles",
     *     operationId="ConferenceControllerGetArticles",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getArticles() {
        $trackIds = Conference::with('tracks')->where('status', '!=', 'finished')->get()->pluck('tracks.*.id')->collapse()->toArray();

        return LogService::read(true, [
            'conferenceArticles' => TrackArticle::with(['user.preferenceUser', 'track', 'user.affilationUser', 'articleComments', 'articleReviews'])->whereIn('track_id', $trackIds)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/article/user/get",
     *     tags={"conference"},
     *     summary="Gets all user articles",
     *     operationId="ConferenceControllerGetUserArticles",
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
    public function getUserArticles(Request $request) {
        $input = $request->all();
        $validation = new ConferenceRequest($input, 'getUserArticles');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackIds = Conference::with('tracks')->where('status', '!=', 'finished')->get()->pluck('tracks.*.id')->collapse()->toArray();

        return LogService::read(true, [
            'conferenceArticles' => TrackArticle::with('articleComments')->where('user_id', $input['user_id'])
                ->whereIn('track_id', $trackIds)
                ->get()
                ->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/create",
     *     tags={"conference"},
     *     summary="Creates conference",
     *     operationId="ConferenceControllerCreate",
     *     @OA\Parameter(
     *         name="acronym",
     *         in="query",
     *         description="Acronym of conference",
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
     *         name="place_pl",
     *         in="query",
     *         description="Place of conference in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="place_en",
     *         in="query",
     *         description="Place of conference in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="place_ru",
     *         in="query",
     *         description="Place of conference in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="website",
     *         in="query",
     *         description="Url of website",
     *         required=false,
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
            'conference' => $conference->load(['conferencePages', 'conferencePreference', 'programmeCommittee', 'conferenceEvents', 'conferenceCfp'])->toArray()
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
     *         name="status",
     *         in="query",
     *         description="Conference status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="acronym",
     *         in="query",
     *         description="Acronym of conference",
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
     *         name="place_pl",
     *         in="query",
     *         description="Place of conference in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="place_en",
     *         in="query",
     *         description="Place of conference in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="place_ru",
     *         in="query",
     *         description="Place of conference in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="website",
     *         in="query",
     *         description="Url of website",
     *         required=false,
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
            'conference' => $conference->load(['conferencePages', 'conferencePreference', 'programmeCommittee', 'conferenceEvents', 'conferenceCfp'])->toArray()
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
