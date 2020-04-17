<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackArticleRequest;
use App\Models\Track;
use App\Models\TrackArticle;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class TrackArticleController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TrackArticleController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/{trackId}",
     *     tags={"track_article"},
     *     summary="Gets all articles belongs to track",
     *     operationId="TrackArticleControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Request $request, Track $track) {
        $input = $request->all();
        $validation = new TrackArticleRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
           'trackArticles' => TrackArticle::where('track_id', $track->id)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/create",
     *     tags={"track_article"},
     *     summary="Create articles to track",
     *     operationId="TrackArticleControllerCreate",
     *     @OA\Parameter(
     *         name="title_pl",
     *         in="query",
     *         description="Title in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title_en",
     *         in="query",
     *         description="Title in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title_ru",
     *         in="query",
     *         description="Title in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_pl",
     *         in="query",
     *         description="Abstract in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_en",
     *         in="query",
     *         description="Abstract in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_ru",
     *         in="query",
     *         description="Abstract in russian language",
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
     *         name="keywords_pl",
     *         in="query",
     *         description="Keywords pl string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keywords_en",
     *         in="query",
     *         description="Keywords en string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keywords_ru",
     *         in="query",
     *         description="Keywords ru string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *         name="track_id",
     *         in="query",
     *         description="Track id",
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
        $validation = new TrackArticleRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackArticle = TrackArticle::addTrackArticle($input, $success);

        return LogService::create($success, [
            'trackArticle' => $trackArticle->load('user')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/update",
     *     tags={"track_article"},
     *     summary="Update article to track",
     *     operationId="TrackArticleControllerUpdate",
     *     @OA\Parameter(
     *         name="title_pl",
     *         in="query",
     *         description="Title in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title_en",
     *         in="query",
     *         description="Title in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title_ru",
     *         in="query",
     *         description="Title in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_pl",
     *         in="query",
     *         description="Abstract in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_en",
     *         in="query",
     *         description="Abstract in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="abstract_ru",
     *         in="query",
     *         description="Abstract in russian language",
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
     *         name="keywords_pl",
     *         in="query",
     *         description="Keywords pl string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keywords_en",
     *         in="query",
     *         description="Keywords en string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keywords_ru",
     *         in="query",
     *         description="Keywords ru string",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *         name="track_id",
     *         in="query",
     *         description="Track id",
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
        $validation = new TrackArticleRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $trackArticle = TrackArticle::updateTrackArticle($input, $success);

        return LogService::update($success, [
            'trackArticle' => $trackArticle->load('user')->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/destroy",
     *     tags={"conference_page"},
     *     summary="Deletes conference track article",
     *     operationId="TrackArticleControllerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Track article id",
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
        $validation = new TrackArticleRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TrackArticle::destroy($input['id']);

        return LogService::delete($success);
    }
}
