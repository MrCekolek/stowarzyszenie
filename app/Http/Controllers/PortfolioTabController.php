<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioTabRequest;
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
        $portfolioTabs = PortfolioTab::where('portfolio_id', $portfolio->id)
            ->get()
            ->toArray();

        return LogService::read(true, [
            'portfolioTabs' => $portfolioTabs
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $portfolioTab = PortfolioTab::create([
                'position' => PortfolioTab::max('position') + 1,
                'portfolio_id' => $input['portfolio_id']
            ]),
            'name'
        );

        return LogService::create($portfolioTab->exists(), [
            'portfolioTab' => $portfolioTab->toArray()
        ]);
    }

    public function update(Request $request, PortfolioTab $portfolioTab) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $portfolioTab->update([
                'position' => $input['position']
            ]),
            'name'
        );

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
