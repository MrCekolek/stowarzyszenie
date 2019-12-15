<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileRequest;
use App\Models\PortfolioTab;
use App\Models\Tile;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class TileController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(PortfolioTab $portfolioTab) {
        $tiles = Tile::where('portfolio_tab_id', $portfolioTab->id)
            ->toArray();

        return LogService::read(true, [
            'tiles' => $tiles
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new TileRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $tile = Tile::create([
                'position' => Tile::max('position'),
                'portfolio_tab_id' => $input['portfolio_tab_id']
            ]),
            'name'
        );

        return LogService::create($tile->exists(), [
            'tile' => $tile->toArray()
        ]);
    }

    public function update(Request $request, Tile $tile) {
        $input = $request->all();
        $validation = new TileRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $tile->update([
                'position' => $input['position']
            ]),
            'name'
        );

        return LogService::update(true, [
            'tile' => $tile->toArray()
        ]);
    }

    public function destroy(Request $request, Tile $tile) {
        $input = $request->all();
        $validation = new TileRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Tile::destroy($tile->id);

        return LogService::delete($success);
    }
}
