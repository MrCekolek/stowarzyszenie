<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleReviewRequest;
use App\Models\ArticleReview;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class ArticleReviewController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ArticleReviewController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/review",
     *     tags={"article_review"},
     *     summary="Gets all reviews belongs to article",
     *     operationId="ArticleReviewControllerIndex",
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
    public function index(Request $request) {
        $input = $request->all();
        $validation = new ArticleReviewRequest($input, 'index');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'articleReviews' => ArticleReview::with(['trackArticle.articleComments', 'trackArticle.user.preferenceUser', 'trackArticle.user.affilationUser'])->where('user_id', $input['user_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/review/show",
     *     tags={"article_review"},
     *     summary="Gets review belongs to article",
     *     operationId="ArticleReviewControllerShow",
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
    public function show(Request $request) {
        $input = $request->all();
        $validation = new ArticleReviewRequest($input, 'show');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'articleReview' => ArticleReview::with(['trackArticle.articleComments', 'trackArticle.user.preferenceUser', 'trackArticle.user.affilationUser'])
                ->where('id', $input['id'])
                ->first()
                ->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/review/create",
     *     tags={"article_review"},
     *     summary="Adds review to article",
     *     operationId="ArticleReviewControllerCreate",
     *     @OA\Parameter(
     *         name="mark",
     *         in="query",
     *         description="Review mark",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Review description",
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
        $validation = new ArticleReviewRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $articleReview = ArticleReview::addArticleReview($input, $success);

        return LogService::create($success, [
            'articleReview' => $articleReview->load(['trackArticle.articleComments', 'trackArticle.user.preferenceUser', 'trackArticle.user.affilationUser'])->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/review/update",
     *     tags={"article_review"},
     *     summary="Updates article review",
     *     operationId="ArticleReviewControllerUpdate",
     *     @OA\Parameter(
     *         name="mark",
     *         in="query",
     *         description="Review mark",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
        $validation = new ArticleReviewRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $articleReview = ArticleReview::updateArticleReview($input, $success);

        return LogService::update($success, [
            'articleReview' => $articleReview->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/review/destroy",
     *     tags={"article_review"},
     *     summary="Removes article review",
     *     operationId="ArticleReviewControllerDestroy",
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
        $validation = new ArticleReviewRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = ArticleReview::where('track_article_id', $input['track_article_id'])
            ->where('user_id', $input['user_id'])
            ->delete();

        return LogService::delete($success);
    }
}
