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

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $tileContent = TileContent::create([
                'type' => $input['type'],
                'translation_key' => TileContent::translations()[$input['type']],
                'tile_id' => $input['tile_id']
            ]),
            'name'
        );

        return LogService::create($tileContent->exists(), [
            'tileContent' => $tileContent->toArray()
        ]);
    }

    public function update(Request $request, TileContent $tileContent) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $tileContent->update([
                'type' => $input['type'],
                'translation_key' => TileContent::translations()[$input['type']],
                'tile_id' => $input['tile_id']
            ]),
            'name'
        );

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
