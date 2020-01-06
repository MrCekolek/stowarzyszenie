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
            'tiles' => Tile::where('portfolio_tab_id', $portfolioTab->id)->get()->toArray()
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new TileRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tile = new Tile();
        $tile->shared_id = Tile::max('shared_id') + 1;
        $tile->name_pl = $input['name_pl'];
        $tile->name_en = $input['name_en'];
        $tile->name_ru = $input['name_ru'];
        $tile->position = Tile::max('position') + 1;
        $tile->portfolio_tab_id = $input['portfolio_tab_id'];
        $tile->portfolio_tab_shared_id = $input['portfolio_tab_shared_id'];
        $success = $tile->save();

        CreateTileJob::dispatch(
            $tile->shared_id,
            $tile->name_pl,
            $tile->name_en,
            $tile->name_ru,
            $tile->position,
            $input['portfolio_tab_id'],
            $input['portfolio_tab_shared_id']
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

        foreach (Tile::where('shared_id', $input['shared_id'])->get() as $tile) {
            $tile->name_pl = $input['name_pl'];
            $tile->name_en = $input['name_en'];
            $tile->name_ru = $input['name_ru'];

            if ($tile->isDirty('position')) {
                $this->changePosition(Tile::class, $tile, $input['position']);
            }

            $tile->admin_visibility = $input['admin_visibility'];
            $tile->user_visibility = $input['user_visibility'];
            $success &= $tile->save();
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

        $success = Tile::where('shared_id', $input['shared_id'])
            ->delete();

        $this->reindexPositions(Tile::class);

        return LogService::delete($success > 0, [
            'tiles' => Tile::where('portfolio_tab_id', $input['portfolio_tab_id'])->get()->toArray()
        ]);
    }
}
