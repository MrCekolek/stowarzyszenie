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

class PortfolioTabController extends Controller {
    use Translatable,
        ChangePosition,
        ManagePortfolio;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(Portfolio $portfolio) {
        return LogService::read(true, [
            'portfolioTabs' => PortfolioTab::where('portfolio_id', $portfolio->id)->get()->toArray()
        ]);
    }

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

    public function updateVisibility(Request $request) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'updateVisibility');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update(self::changeVisibility($input, PortfolioTab::class));
    }
}
