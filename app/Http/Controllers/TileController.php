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
            ->get()
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

        $tile = new Tile();
        $tile->name_pl = $input['name_pl'];
        $tile->name_en = $input['name_en'];
        $tile->name_ru = $input['name_ru'];
        $tile->position = Tile::max('position') + 1;
        $tile->portfolio_tab_id = $input['portfolio_tab_id'];
        $saved = $tile->save();

        return LogService::create($saved, [
            'tile' => $tile->toArray()
        ]);
    }

    public function update(Request $request, Tile $tile) {
        $input = $request->all();
        $validation = new TileRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tile->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru'],
            'position' => $input['position']
        ]);

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
