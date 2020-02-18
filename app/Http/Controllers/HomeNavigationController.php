<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeNavigationRequest;
use App\Models\HomeNavigation;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class HomeNavigationController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class HomeNavigationController extends Controller {
    /**
     * @OA\Post(
     *     path="/home_navigation/get",
     *     tags={"home_navigation"},
     *     summary="Gets all home navigation links with content",
     *     operationId="HomeNavigationControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'home_navigations' => HomeNavigation::all()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/home_navigation/create",
     *     tags={"home_navigation"},
     *     summary="Creates home navigation",
     *     operationId="HomeNavigationControllerCreate",
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
     *         name="link",
     *         in="query",
     *         description="Home Navigation destination link",
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
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function create(Request $request) {
        $input = $request->all();
        $validation = new HomeNavigationRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $homeNavigation = new HomeNavigation();
        $homeNavigation->name_pl = $input['name_pl'];
        $homeNavigation->name_en = $input['name_en'];
        $homeNavigation->name_ru = $input['name_ru'];
        $homeNavigation->link = $input['link'];
        $homeNavigation->content_pl = $input['content_pl'];
        $homeNavigation->content_en = $input['content_en'];
        $homeNavigation->content_ru = $input['content_ru'];
        $success = $homeNavigation->save();

        return LogService::create($success, [
            'home_navigation' => $homeNavigation->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/home_navigation/update",
     *     tags={"home_navigation"},
     *     summary="Updates home navigation",
     *     operationId="HomeNavigationControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Home navigation id",
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
     *         name="link",
     *         in="query",
     *         description="Home Navigation destination link",
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
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function update(Request $request) {
        $input = $request->all();
        $validation = new HomeNavigationRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $homeNavigation = HomeNavigation::where('id', $input['id'])->first();
        $homeNavigation->name_pl = $input['name_pl'];
        $homeNavigation->name_en = $input['name_en'];
        $homeNavigation->name_ru = $input['name_ru'];
        $homeNavigation->link = $input['link'];
        $homeNavigation->content_pl = $input['content_pl'];
        $homeNavigation->content_en = $input['content_en'];
        $homeNavigation->content_ru = $input['content_ru'];
        $success = $homeNavigation->save();

        return LogService::update($success, [
            'home_navigation' => $homeNavigation->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/home_navigation/destroy",
     *     tags={"home_navigation"},
     *     summary="Destroys home navigation",
     *     operationId="HomeNavigationControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Home navigation id",
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
        $validation = new HomeNavigationRequest($input,'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = HomeNavigation::destroy($input['id']);

        return LogService::delete($success);
    }
}
