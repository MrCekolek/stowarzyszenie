<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestRequest;
use App\Models\Interest;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class InterestController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class InterestController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/interest/get",
     *     tags={"interest"},
     *     summary="Gets all interests",
     *     operationId="InterestControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'interests' => Interest::all()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/create",
     *     tags={"interest"},
     *     summary="Creates interest",
     *     operationId="InterestControllerCreate",
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
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function create(Request $request) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $interest = new Interest();
        $interest->name_pl = $input['name_pl'];
        $interest->name_en = $input['name_en'];
        $interest->name_ru = $input['name_ru'];
        $success = $interest->save();

        return LogService::create($success, [
            'interest' => $interest->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/update",
     *     tags={"interest"},
     *     summary="Updates interest",
     *     operationId="InterestControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Interest id",
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
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function update(Request $request, Interest $interest) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = $interest->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru']
        ]);

        return LogService::update($success > 0, [
            'interest' => $interest->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/interest/destroy",
     *     tags={"interest"},
     *     summary="Destroys interest",
     *     operationId="InterestControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Interest id",
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
    public function destroy(Request $request, Interest $interest) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Interest::destroy($interest->id);

        return LogService::delete($success > 0);
    }
}
