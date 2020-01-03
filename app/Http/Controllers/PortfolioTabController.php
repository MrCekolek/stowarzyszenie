<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioTabRequest;
use App\Jobs\CreatePortfolioTabsJob;
use App\Models\Portfolio;
use App\Models\PortfolioTab;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class PortfolioTabController extends Controller {
    use Translatable;

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

        $position = PortfolioTab::max('position') + 1;
        $userPortfolioId = auth()->user()->portfolio()->first()->id;

        $portfolioTab = new PortfolioTab();
        $portfolioTab->name_pl = $input['name_pl'];
        $portfolioTab->name_en = $input['name_en'];
        $portfolioTab->name_ru = $input['name_ru'];
        $portfolioTab->position = $position;
        $portfolioTab->portfolio_id = $userPortfolioId;
        $saved = $portfolioTab->save();

        CreatePortfolioTabsJob::dispatch(
            $portfolioTab->name_pl,
            $portfolioTab->name_en,
            $portfolioTab->name_ru,
            $position,
            $userPortfolioId
        );

        return LogService::create($saved, [
            'portfolioTab' => $portfolioTab->toArray()
        ]);
    }

    public function update(Request $request, PortfolioTab $portfolioTab) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $portfolioTab->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru'],
            'position' => $input['position']
        ]);

        return LogService::update(true, [
            'portfolioTab' => $portfolioTab->toArray()
        ]);
    }

    public function destroy(Request $request, PortfolioTab $portfolioTab) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = PortfolioTab::destroy($portfolioTab->id);

        return LogService::delete($success);
    }
}
