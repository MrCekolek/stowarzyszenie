<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentRequest;
use App\Jobs\CreateContentJob;
use App\Models\Content;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\ManagePortfolio;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class ContentController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ContentController extends Controller {
    use Translatable,
        ChangePosition,
        ManagePortfolio;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/{cardContentId}/get",
     *     tags={"content_option"},
     *     summary="Gets all options that belongs to specific card content",
     *     operationId="ContentControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(TileContent $tileContent) {
        return LogService::read(true, [
            'tiles' =>  Content::where('tile_content_id', $tileContent->id)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/create",
     *     tags={"content_option"},
     *     summary="Creates content option",
     *     operationId="ContentControllerCreate",
     *     @OA\Parameter(
     *         name="value_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_ru",
     *         in="query",
     *         description="Translation in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_id",
     *         in="query",
     *         description="Card content id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_shared_id",
     *         in="query",
     *         description="Card content shared_id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_shared_id",
     *         in="query",
     *         description="Card shared id",
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
        $validation = new ContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        CreateContentJob::dispatch(
            $content = Content::addContent($input, $success),
            $input
        );

        return LogService::create($success, [
            'content' => $content->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/update",
     *     tags={"content_option"},
     *     summary="Updates content option",
     *     operationId="ContentControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Content option shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="value_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_ru",
     *         in="query",
     *         description="Translation in russian language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="selected",
     *         in="query",
     *         description="Is option selected?",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="position",
     *         in="query",
     *         description="Content option position",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="admin_visibility",
     *         in="query",
     *         description="Admin visibility",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_visibility",
     *         in="query",
     *         description="User visibility",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_id",
     *         in="query",
     *         description="Card content id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_shared_id",
     *         in="query",
     *         description="Card content shared id",
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
        $success = true;
        $input = $request->all();
        $validation = new ContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (Content::where('shared_id', $input['shared_id'])->get() as $content) {
            Content::updateContent($content, $input, $success);
        }

        return LogService::update($success, [
            'content' => Content::where('id', $input['id'])->first()->id
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/destroy",
     *     tags={"content_option"},
     *     summary="Deletes specific card content option",
     *     operationId="ContentConteollerDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Content option shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_id",
     *         in="query",
     *         description="Card content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_content_shared_id",
     *         in="query",
     *         description="Card content option shared id",
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
        $validation = new ContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Content::where('tile_content_shared_id', $input['tile_content_shared_id'])
            ->where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(Content::class);

        return LogService::delete($success > 0, [
            'contents' => Content::where('tile_content_id', $input['tile_content_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/visibility/update",
     *     tags={"content_option"},
     *     summary="Changes card content option admin or user visibility",
     *     operationId="ContentControllerUpdateVisibility",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card content option shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="field",
     *         in="query",
     *         description="Admin or user visibility in:admin,user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visibility",
     *         in="query",
     *         description="Visibility in:true,false",
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
    public function updateVisibility(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'updateVisibility');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeVisibility($input, Content::class));
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/selected/update",
     *     tags={"content_option"},
     *     summary="Changes card content option admin or user visibility",
     *     operationId="ContentControllerUpdateSelected",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="selected",
     *         in="query",
     *         description="Is card content option selected?",
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
    public function updateSelected(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'updateSelected');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeSelected($input, Content::where('id', $input['id'])->first()));
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/content/filled/update",
     *     tags={"content_option"},
     *     summary="Changes card content option admin or user visibility",
     *     operationId="ContentControllerUpdateFilled",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card content option id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="value_ru",
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
    public function updateFilled(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'updateFilled');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeFilled($input, Content::where('id', $input['id'])->first()));
    }
}
