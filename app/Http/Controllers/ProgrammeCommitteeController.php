<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgrammeCommitteeRequest;
use App\Models\ProgrammeCommittee;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ProgrammeCommitteeController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ProgrammeCommitteeController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="conference/programme_committee",
     *     tags={"programme_committee"},
     *     summary="Read all users that belongs to conference programme committee",
     *     operationId="ProgrammeCommitteeIndex",
     *      @OA\Parameter(
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

        $validation = new ProgrammeCommitteeRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'programmeCommittees' => ProgrammeCommittee::where('conference_id', $input['conference_id'])->with('user.preferenceUser')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="conference/programme_committee/create",
     *     tags={"programme_committee"},
     *     summary="Assign user to conference programme committee",
     *     operationId="ProgrammeCommitteeCreate",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="conference_id",
     *         in="query",
     *         description="Conference id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="contact_email",
     *         in="query",
     *         description="Contact email of user",
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

        $validation = new ProgrammeCommitteeRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $programmeCommittee = new ProgrammeCommittee();
        $programmeCommittee->user_id = $input['user_id'];
        $programmeCommittee->conference_id = $input['conference_id'];
        $programmeCommittee->contact_email = $input['contact_email'];
        $success = $programmeCommittee->save();

        return LogService::create($success, [
            'programmeCommittee' => $programmeCommittee->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="conference/programme_committee/createMulti",
     *     tags={"programme_committee"},
     *     summary="Assign user to conference programme committee",
     *     operationId="ProgrammeCommitteeCreate",
     *     @OA\Parameter(
     *         name="users",
     *         in="query",
     *         description="Users",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
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
    public function createMulti(Request $request) {
        $input = $request->all();
        $success = true;
        $validation = new ProgrammeCommitteeRequest($input, 'createMulti');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        ProgrammeCommittee::where('conference_id', $input['conference_id'])->delete();

        foreach ($input['users'] as $user) {
            $programmeCommittee = new ProgrammeCommittee();
            $programmeCommittee->user_id = $user['id'];
            $programmeCommittee->conference_id = $input['conference_id'];
            $programmeCommittee->contact_email = '';
            $success &= $programmeCommittee->save();
        }

        return LogService::create($success, [
            'programmeCommittees' => ProgrammeCommittee::where('conference_id', $input['conference_id'])->with('user.preferenceUser')->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="conference/programme_committee/update",
     *     tags={"programme_committee"},
     *     summary="Update programme committee",
     *     operationId="ProgrammeCommitteeUpdate",
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
     *         name="contact_email",
     *         in="query",
     *         description="Contact email of user",
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

        $validation = new ProgrammeCommitteeRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $programmeCommittee = ProgrammeCommittee::where('user_id', $input['user_id'])
            ->where('conference_id', $input['conference_id'])->first();
        $programmeCommittee->contact_email = $input['contact_email'];
        $success = $programmeCommittee->save();

        return LogService::create($success, [
            'programmeCommittee' => $programmeCommittee->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="conference/programme_committee/destroy",
     *     tags={"programme_committee"},
     *     summary="Deassign user to conference programme committee",
     *     operationId="ProgrammeCommitteeDestroy",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
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

        $validation = new ProgrammeCommitteeRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ProgrammeCommittee::where('user_id', $input['user_id'])
            ->where('conference_id', $input['conference_id'])
            ->delete();

        return LogService::delete($success);
    }
}
