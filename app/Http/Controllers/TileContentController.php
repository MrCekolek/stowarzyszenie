<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileContentRequest;
use App\Jobs\CreateTileContentJob;
use App\Models\Tile;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class TileContentController extends Controller {
    use Translatable,
        ChangePosition;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(Tile $tile) {
        return LogService::read(true, [
            'tileContents' => TileContent::with('contents')->where('tile_id', $tile->id)->get()->toArray()
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tileContent = TileContent::addTileContent($input, $success);

        if ($success) {
            $contents = TileContent::addContent($tileContent, $input['options']);
        }

        CreateTileContentJob::dispatch(
            $tileContent,
            $input,
            $contents
        );

        return LogService::create($success, [
            'tileContent' => TileContent::with('contents')->where('id', $tileContent->id)->get()->toArray()
        ]);
    }

    public function update(Request $request) {
        $success = true;
        $input = $request->all();
        $validation = new TileContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (TileContent::where('tile_shared_id', $input['tile_shared_id'])
                     ->where('shared_id', $input['shared_id'])
                     ->get() as $tileContent) {
            TileContent::updateTileContent($tileContent, $input, $success);
        }

        return LogService::update($success, [
            'tileContent' => TileContent::with('contents')
                ->where('id', $input['id'])
                ->first()
                ->toArray()
        ]);
    }

    public function destroy(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TileContent::where('tile_shared_id', $input['tile_shared_id'])
            ->where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(TileContent::class);

        return LogService::delete($success > 0, [
            'tileContents' => TileContent::where('tile_id', $input['tile_id'])->get()->toArray()
        ]);
    }
}
