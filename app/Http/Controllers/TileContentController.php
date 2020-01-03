<?php

namespace App\Http\Controllers;

use App\Http\Requests\TileContentRequest;
use App\Models\Tile;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class TileContentController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(Tile $tile) {
        $tileContents = TileContent::where('tile_id', $tile->id)
            ->toArray();

        return LogService::read(true, [
            'tileContents' => $tileContents
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }
        $tileContent = new TileContent();
        $tileContent->name_pl = $input['name_pl'];
        $tileContent->name_en = $input['name_en'];
        $tileContent->name_ru = $input['name_ru'];
        $tileContent->type = $input['type'];
        $tileContent->translation_key = TileContent::translations()[$input['type']];
        $tileContent->tile_id = $input['tile_id'];
        $saved = $tileContent->save();

        return LogService::create($saved, [
            'tileContent' => $tileContent->toArray()
        ]);
    }

    public function update(Request $request, TileContent $tileContent) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tileContent->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru'],
            'type' => $input['type'],
            'translation_key' => TileContent::translations()[$input['type']],
            'tile_id' => $input['tile_id']
        ]);

        return LogService::update(true, [
            'tileContent' => $tileContent->toArray()
        ]);
    }

    public function destroy(Request $request, TileContent $tileContent) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TileContent::destroy($tileContent->id);

        return LogService::delete($success);
    }
}
