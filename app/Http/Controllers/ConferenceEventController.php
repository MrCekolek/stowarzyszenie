<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceEventRequest;
use App\Models\ConferenceEvent;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferenceEventController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferenceEventController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/event/get",
     *     tags={"conference_event"},
     *     summary="Gets all conference events",
     *     operationId="ConferenceEventControllerIndex",
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
        $validation = new ConferenceEventRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'conferenceEvents' => ConferenceEvent::where('id', $input['conference_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/event/create",
     *     tags={"conference_event"},
     *     summary="Creates event for conference",
     *     operationId="ConferenceEventControllerCreate",
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
     *         name="date",
     *         in="query",
     *         description="Date of event",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="colour",
     *         in="query",
     *         description="Event colour",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_pl",
     *         in="query",
     *         description="Description in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_en",
     *         in="query",
     *         description="Description in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_ru",
     *         in="query",
     *         description="Description in russian language",
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
        $validation = new ConferenceEventRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceEvent = ConferenceEvent::addConferenceEvent($input, $success);

        return LogService::create($success, [
            'conferenceEvent' => $conferenceEvent->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/event/update",
     *     tags={"conference_event"},
     *     summary="Updates event for conference",
     *     operationId="ConferenceEventControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ConferenceEvent id",
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
     *         name="date",
     *         in="query",
     *         description="Date of event",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="colour",
     *         in="query",
     *         description="Event colour",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_pl",
     *         in="query",
     *         description="Description in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_en",
     *         in="query",
     *         description="Description in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description_ru",
     *         in="query",
     *         description="Description in russian language",
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
        $validation = new ConferenceEventRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceEvent = ConferenceEvent::updateConferenceEvent($input, $success);

        return LogService::update($success, [
            'conferenceEvent' => $conferenceEvent->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/event/destroy",
     *     tags={"conference_event"},
     *     summary="Deletes conference event",
     *     operationId="ConferenceEventControllerDestroy",
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
        $validation = new ConferenceEventRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ConferenceEvent::destroy($input['id']);

        return LogService::delete($success);
    }
}
