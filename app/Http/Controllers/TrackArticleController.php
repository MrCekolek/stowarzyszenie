<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackArticleRequest;
use App\Models\ArticleReview;
use App\Models\Track;
use App\Models\TrackArticle;
use App\Models\TrackReviewer;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function foo\func;

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
     *     path="/conference/track/article/show",
     *     tags={"track_article"},
     *     summary="Gets article belongs to track",
     *     operationId="TrackArticleControllerShow",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function show(Request $request) {
        $input = $request->all();
        $validation = new TrackArticleRequest($input, 'show');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::read(true, [
            'trackArticle' => TrackArticle::with('articleComments')->where('id', $input['id'])->first()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/conference/track/article/reviewer/get",
     *     tags={"track_article"},
     *     summary="Gets article reviewers",
     *     operationId="TrackArticleControllerGetReviewers",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getReviewers(Request $request) {
        $input = $request->all();
        $validation = new TrackArticleRequest($input, 'getReviewers');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $languages = [
            'pl',
            'en',
            'ru'
        ];
        $interestWeight = 2;
        $keywordsWeight = 2;

        $trackArticle = TrackArticle::where('id', $input['id'])->get();
        $userArticle = $trackArticle->load('user.interests');
        $trackArticleInterestId = $trackArticle->load('track')->pluck('track.interest_id')[0];
        $trackReviewersIds = $trackArticle->load('track.trackReviewers')->pluck('track.trackReviewers.*.id')->collapse()->toArray();

        $possibleReviewers = User::with(['interests', 'preferenceUser', 'affilationUser'])
            ->whereIn('id', $trackReviewersIds)
            ->where('id', '!=', $trackArticle->first()->user_id);

//            ->whereHas('interests', function (Builder $query) use ($trackArticleInterestId) {
//                $query->where('interests.id', '=', $trackArticleInterestId);
//            });

        $possibleReviewers->each(function($reviewer) use ($userArticle, $interestWeight, $keywordsWeight, $languages) {
            $reviewer->ratings = count(array_intersect(
               $userArticle->pluck('user.interests.*.id')->collapse()->toArray(),
               $reviewer->interests->pluck('id')->toArray()
           )) * $interestWeight;

           ArticleReview::with('trackArticle')
               ->where('user_id', $reviewer->id)
               ->each(function ($articleReview) use (&$reviewer, $userArticle, $keywordsWeight, $languages) {
                   $userArticle = $userArticle->first();

                   foreach ($languages as $language) {
                       $reviewer->ratings += count(array_intersect(
                               explode(',', $articleReview->trackArticle->{'keywords_' . $language}),
                               explode(',', $userArticle->{'keywords_' . $language})
                           )) * $keywordsWeight;
                   }
               });
        });

        return LogService::read(true, [
            'possibleReviewers' => $possibleReviewers->get()->toArray(),
            'bestReviewers' => $possibleReviewers->get()->sortBy('ratings')->take(3)->toArray()
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

        $trackArticle = TrackArticle::addTrackArticle($request, $input, $success);

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

        $trackArticle = TrackArticle::updateTrackArticle($request, $input, $success);

        return LogService::update($success, [
            'trackArticle' => $trackArticle->load(['track', 'user.preferenceUser', 'user.affilationUser', 'articleComments'])->toArray()
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
