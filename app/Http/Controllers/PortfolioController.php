<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class PortfolioController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class PortfolioController extends Controller {
    /**
     * @OA\Post(
     *     path="/interest/user/{userId}/get",
     *     tags={"interest_user"},
     *     summary="Gets all interests that belongs to user",
     *     operationId="InterestControllerIndex",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Portfolio id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Portfolio description",
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
        $validation = new PortfolioRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $portfolio = Portfolio::where('id', $input['id'])
            ->first();
        $portfolio->description = $input['description'];
        $success = $portfolio->save();

        return LogService::update($success);
    }
}
