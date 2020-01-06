<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioTabRequest;
use App\Jobs\CreatePortfolioTabsJob;
use App\Models\Portfolio;
use App\Models\PortfolioTab;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class PortfolioTabController extends Controller {
    use Translatable,
        ChangePosition;

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

        $portfolioTab = new PortfolioTab();
        $portfolioTab->shared_id = PortfolioTab::max('shared_id') + 1;
        $portfolioTab->name_pl = $input['name_pl'];
        $portfolioTab->name_en = $input['name_en'];
        $portfolioTab->name_ru = $input['name_ru'];
        $portfolioTab->position = PortfolioTab::max('position') + 1;
        $portfolioTab->portfolio_id = $input['portfolio_id'];
        $success = $portfolioTab->save();

        CreatePortfolioTabsJob::dispatch(
            $portfolioTab->shared_id,
            $portfolioTab->name_pl,
            $portfolioTab->name_en,
            $portfolioTab->name_ru,
            $portfolioTab->position,
            $input['portfolio_id']
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
            $portfolioTab->name_pl = $input['name_pl'];
            $portfolioTab->name_en = $input['name_en'];
            $portfolioTab->name_ru = $input['name_ru'];

            if ($portfolioTab->isDity('position')) {
                $this->changePosition(PortfolioTab::class, $portfolioTab, $input['position']);
            }

            $portfolioTab->admin_visibility = $input['admin_visibility'];
            $portfolioTab->user_visibility = $input['user_visibility'];
            $success &= $portfolioTab->save();
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

        $this->reindexPositions(PortfolioTab::class);

        return LogService::delete($success > 0);
    }
}
