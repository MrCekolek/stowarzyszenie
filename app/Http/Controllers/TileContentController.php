<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileContentRequest;
use App\Jobs\CreateTileContentJob;
use App\Models\Tile;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\ManagePortfolio;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class TileContentController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TileContentController extends Controller {
    use Translatable,
        ChangePosition,
        ManagePortfolio;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/{cardId}/get",
     *     tags={"card_content"},
     *     summary="Gets all card contents",
     *     operationId="TileContentIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Tile $tile) {
        return LogService::read(true, [
            'tileContents' => TileContent::with('contents')->where('tile_id', $tile->id)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/create",
     *     tags={"card_content"},
     *     summary="Creates card content",
     *     operationId="TileContentControllerCreate",
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
     *         name="type",
     *         in="query",
     *         description="Card content type",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_id",
     *         in="query",
     *         description="Card id",
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
        $validation = new TileContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tileContent = TileContent::addTileContent($input, $success);

        if ($success) {
            $contents = TileContent::addContent($tileContent, $input['options']);
        }

        CreateTileContentJob::dispatch(
            $tileContent,
            $input,
            $contents
        );

        return LogService::create($success, [
            'tileContent' => TileContent::with('contents')->where('id', $tileContent->id)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/update",
     *     tags={"card_content"},
     *     summary="Updates card content",
     *     operationId="TileContentControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card content id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card content shared id",
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
     *         name="type",
     *         in="query",
     *         description="Card content type",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="position",
     *         in="query",
     *         description="Card content position",
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
     *         name="tile_id",
     *         in="query",
     *         description="Card id",
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
    public function update(Request $request) {
        $success = true;
        $input = $request->all();
        $validation = new TileContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (TileContent::where('tile_shared_id', $input['tile_shared_id'])
                     ->where('shared_id', $input['shared_id'])
                     ->get() as $tileContent) {
            TileContent::updateTileContent($tileContent, $input, $success);
        }

        return LogService::update($success, [
            'tileContent' => TileContent::with('contents')
                ->where('id', $input['id'])
                ->first()
                ->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/destroy",
     *     tags={"card_content"},
     *     summary="Deletes specific card content",
     *     operationId="TileContentControllerDestroy",
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card content shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tile_id",
     *         in="query",
     *         description="Card id",
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
    public function destroy(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TileContent::where('tile_shared_id', $input['tile_shared_id'])
            ->where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(TileContent::class);

        return LogService::delete($success > 0, [
            'tileContents' => TileContent::where('tile_id', $input['tile_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/content/visibility/update",
     *     tags={"card_content"},
     *     summary="Changes card content admin or user visibility",
     *     operationId="TileContentControllerUpdateVisibility",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card content id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card content shared id",
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
        $validation = new TileContentRequest($input, 'updateVisibility');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeVisibility($input, (new TileContent())));
    }
}
