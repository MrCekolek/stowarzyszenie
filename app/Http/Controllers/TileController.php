<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileRequest;
use App\Jobs\CreateTileJob;
use App\Models\PortfolioTab;
use App\Models\Tile;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class TileController extends Controller {
    use Translatable,
        ChangePosition;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(PortfolioTab $portfolioTab) {
        return LogService::read(true, [
            'tiles' => Tile::with('tileContents.contents')
                ->where('portfolio_tab_id', $portfolioTab->id)
                ->get()
                ->toArray()
        ]);
    }

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
}
