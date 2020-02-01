<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileRequest;
use App\Jobs\CreateTileJob;
use App\Models\PortfolioTab;
use App\Models\Tile;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\ManagePortfolio;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class TileController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TileController extends Controller {
    use Translatable,
        ChangePosition,
        ManagePortfolio;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/{portfolioTabId}/get",
     *     tags={"card"},
     *     summary="Gets all cards that belongs to portfolio tab with contents",
     *     operationId="TileControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(PortfolioTab $portfolioTab) {
        return LogService::read(true, [
            'tiles' => Tile::with('tileContents.contents')
                ->where('portfolio_tab_id', $portfolioTab->id)
                ->get()
                ->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/create",
     *     tags={"card"},
     *     summary="Creates card",
     *     operationId="TileControllerCreate",
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
     *         name="portfolio_tab_id",
     *         in="query",
     *         description="Portfolio tab id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolio_tab_shared_id",
     *         in="query",
     *         description="Portfolio tab shared id",
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
        $validation = new TileRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        CreateTileJob::dispatch(
            $tile = Tile::addTile($input, $success),
            $input
        );

        return LogService::create($success, [
            'tile' => $tile->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/update",
     *     tags={"card"},
     *     summary="Updates card",
     *     operationId="TileControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Tile id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Tile shared id",
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
     *         name="position",
     *         in="query",
     *         description="Tile's position",
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
     *         name="portfolio_tab_id",
     *         in="query",
     *         description="Portfolio tab id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolio_tab_shared_id",
     *         in="query",
     *         description="Portfolio tab shared id",
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
        $validation = new TileRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (Tile::where('portfolio_tab_shared_id', $input['portfolio_tab_shared_id'])
                 ->where('shared_id', $input['shared_id'])
                 ->get() as $tile) {
            Tile::updateTile($tile, $input, $success);
        }

        return LogService::update($success, [
            'tile' => Tile::where('id', $input['id'])->first()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/destroy",
     *     tags={"card"},
     *     summary="Deletes specific card",
     *     operationId="TileControllerDestroy",
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolio_tab_id",
     *         in="query",
     *         description="Card portfolio tab id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolio_tab_shared_id",
     *         in="query",
     *         description="Card portfolio tab shared id",
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
        $validation = new TileRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Tile::where('portfolio_tab_shared_id', $input['portfolio_tab_shared_id'])
            ->where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(Tile::class);

        return LogService::delete($success > 0, [
            'tiles' => Tile::where('portfolio_tab_id', $input['portfolio_tab_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tile/visibility/update",
     *     tags={"card"},
     *     summary="Changes card admin or user visibility",
     *     operationId="TileControllerUpdateVisibility",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Card id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="Card shared id",
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
        $validation = new TileRequest($input, 'updateVisibility');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeVisibility($input, Tile::class));
    }
}
