<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceCfpRequest;
use App\Models\ConferenceCfp;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ConferenceCfpController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ConferenceCfpController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/cfp",
     *     tags={"conference_cfp"},
     *     summary="Gets all conference cfps",
     *     operationId="ConferenceCfpControllerIndex",
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
        $validation = new ConferenceCfpRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'conferenceCfps' => ConferenceCfp::where('id', $input['conference_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/cfp/create",
     *     tags={"conference_cfp"},
     *     summary="Creates cfp for conference",
     *     operationId="ConferenceCfpControllerCreate",
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
     *         name="content_pl",
     *         in="query",
     *         description="Content in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_en",
     *         in="query",
     *         description="Content in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_ru",
     *         in="query",
     *         description="Content in russian language",
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
        $validation = new ConferenceCfpRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceCfp = ConferenceCfp::addConferenceCfp($request, $input, $success);

        return LogService::create($success, [
            'conferenceCfp' => $conferenceCfp->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/cfp/update",
     *     tags={"conference_cfp"},
     *     summary="Updates cfp for conference",
     *     operationId="ConferenceCfpControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference Cfp id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *         name="content_pl",
     *         in="query",
     *         description="Content in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_en",
     *         in="query",
     *         description="Content in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content_ru",
     *         in="query",
     *         description="Content in russian language",
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
        $validation = new ConferenceCfpRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $conferenceCfp = ConferenceCfp::updateConferenceCfp($request, $input, $success);

        return LogService::update($success, [
            'conferenceCfp' => $conferenceCfp->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/cfp/destroy",
     *     tags={"conference_cfp"},
     *     summary="Deletes conference cfp",
     *     operationId="ConferenceCfpControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Conference cfp id",
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
        $validation = new ConferenceCfpRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ConferenceCfp::destroy($input['id']);

        return LogService::delete($success);
    }
}
