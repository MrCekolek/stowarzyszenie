<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioTabRequest;
use App\Jobs\CreatePortfolioTabsJob;
use App\Models\Portfolio;
use App\Models\PortfolioTab;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\ManagePortfolio;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class PortfolioTabController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class PortfolioTabController extends Controller {
    use Translatable,
        ChangePosition,
        ManagePortfolio;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tabs/{portfolioId}/get",
     *     tags={"portfolio_tab"},
     *     summary="Gets portfolio tabs",
     *     operationId="PortfolioTabControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Portfolio $portfolio) {
        return LogService::read(true, [
            'portfolioTabs' => PortfolioTab::with(['tiles.tileContents.contents'])
                ->where('portfolio_id', $portfolio->id)->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tabs/create",
     *     tags={"portfolio_tab"},
     *     summary="Creates portfolio tab",
     *     operationId="PortfolioTabControllerCreate",
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
        $validation = new PortfolioTabRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        CreatePortfolioTabsJob::dispatch(
            $portfolioTab = PortfolioTab::addPortfolioTab($input, $success),
            $input
        );

        return LogService::create($success, [
            'portfolioTab' => $portfolioTab->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tabs/update",
     *     tags={"portfolio_tab"},
     *     summary="Updates portfolio tab",
     *     operationId="PortfolioTabControllerUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="PortfolioTab id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="PortfolioTab shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="position",
     *         in="query",
     *         description="PortfolioTab position",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="admin_visibility",
     *         in="query",
     *         description="PortfolioTab admin visibility",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_visibility",
     *         in="query",
     *         description="PortfolioTab user visibility",
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
    public function update(Request $request) {
        $success = true;
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (PortfolioTab::where('shared_id', $input['shared_id'])->get() as $portfolioTab) {
            PortfolioTab::updatePortfolioTab($portfolioTab, $input, $success);
        }

        return LogService::update($success, [
            'portfolioTab' => PortfolioTab::where('id', $input['id'])->first()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tabs/destroy",
     *     tags={"portfolio_tab"},
     *     summary="Destroys portfolio tab",
     *     operationId="PortfolioTabControllerDestroy",
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="PortfolioTab shared id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolio_id",
     *         in="query",
     *         description="PortfolioTab portfolio id",
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
        $validation = new PortfolioTabRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = PortfolioTab::where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(PortfolioTab::class);

        return LogService::delete($success > 0, [
            'portfolioTabs' => PortfolioTab::where('portfolio_id', $input['portfolio_id'])->get()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/portfolio/tabs/visibility/update",
     *     tags={"portfolio_tab"},
     *     summary="Changes portfolio tab's admin or user visibility",
     *     operationId="PortfolioTabControllerUpdateVisibility",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="PortfolioTab id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="shared_id",
     *         in="query",
     *         description="PortfolioTab shared id",
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
        $validation = new PortfolioTabRequest($input, 'updateVisibility');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeVisibility($input, PortfolioTab::class));
    }
}
