<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCommentRequest;
use App\Models\ArticleComment;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ArticleCommentController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ArticleCommentController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/comment",
     *     tags={"article_comment"},
     *     summary="Gets all comments belongs to article",
     *     operationId="ArticleCommentControllerIndex",
     *     @OA\Parameter(
     *         name="track_article_id",
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
    public function index(Request $request) {
        $input = $request->all();
        $validation = new ArticleCommentRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'articleComments' => ArticleComment::where('track_article_id', $input['track_article_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/comment/create",
     *     tags={"article_comment"},
     *     summary="Adds comment to article",
     *     operationId="ArticleCommentControllerCreate",
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Comment description",
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
     *         name="track_article_id",
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
    public function create(Request $request) {
        $input = $request->all();
        $validation = new ArticleCommentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $articleComment = new ArticleComment();
        $articleComment->description = $input['description'];
        $articleComment->user_id = $input['user_id'];
        $articleComment->track_article_id = $input['track_article_id'];
        $success = $articleComment->save();

        return LogService::create($success, [
            'articleComment' => $articleComment->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/comment/update",
     *     tags={"article_comment"},
     *     summary="Updates article comment",
     *     operationId="ArticleCommentControllerUpdate",
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Comment description",
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
     *         name="track_article_id",
     *         in="query",
     *         description="Track Article id",
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
        $validation = new ArticleCommentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $articleComment = ArticleComment::where('user_id', $input['user_id'])
            ->where('track_article_id', $input['track_article_id'])
            ->first();
        $articleComment->description = $input['description'];
        $success = $articleComment->save();

        return LogService::update($success, [
            'articleComment' => $articleComment->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/comment/destroy",
     *     tags={"article_comment"},
     *     summary="Removes article comment",
     *     operationId="ArticleCommentControllerDestroy",
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
     *         name="track_article_id",
     *         in="query",
     *         description="Track Article id",
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
        $validation = new ArticleCommentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ArticleComment::where('track_article_id', $input['track_article_id'])
            ->where('user_id', $input['user_id'])
            ->delete();

        return LogService::delete($success);
    }
}
