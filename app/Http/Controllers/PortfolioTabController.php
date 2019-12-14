<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioTabRequest;
use App\Models\PortfolioTab;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class PortfolioTabController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(User $user) {
        $portfolioTabs = PortfolioTab::where('portfolio_id', $user->portfolio->id)
            ->toArray();

        return LogService::read(true, $portfolioTabs);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new PortfolioTabRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->portfolio()->preference_user()->lang,
            $input['name'],
            $portfolioTab = PortfolioTab::create([
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
            auth()->user()->portfolio()->preference_user()->lang,
            $input['name'],
            PortfolioTab::whereId($portfolioTab->id),
            'name'
        );

        return LogService::update();
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
