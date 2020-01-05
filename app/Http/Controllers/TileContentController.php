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
            'tileContents' => TileContent::where('tile_id', $tile->id)->toArray()
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $tileContent = new TileContent();
        $tileContent->shared_id = TileContent::max('shared_id') + 1;
        $tileContent->name_pl = $input['name_pl'];
        $tileContent->name_en = $input['name_en'];
        $tileContent->name_ru = $input['name_ru'];
        $tileContent->type = $input['type'];
        $tileContent->translation_key = TileContent::translations()[$input['type']];
        $tileContent->position = TileContent::max('position') + 1;
        $tileContent->tile_id = $input['tile_id'];
        $tileContent->tile_shared_id = $input['tile_shared_id'];
        $success = $tileContent->save();

        CreateTileContentJob::dispatch(
            $tileContent->shared_id,
            $tileContent->name_pl,
            $tileContent->name_en,
            $tileContent->name_ru,
            $tileContent->type,
            $tileContent->translation_key,
            $tileContent->position,
            $input['tile_id'],
            $input['tile_shared_id']
        );

        return LogService::create($success, [
            'tileContent' => $tileContent->toArray()
        ]);
    }

    public function update(Request $request) {
        $success = true;
        $input = $request->all();
        $validation = new TileContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (TileContent::where('shared_id', $input['shared_id'])->get() as $tileContent) {
            $tileContent->name_pl = $input['name_pl'];
            $tileContent->name_en = $input['name_en'];
            $tileContent->name_ru = $input['name_ru'];
            $tileContent->type = $input['type'];
            $tileContent->translation_key = TileContent::translations()[$input['type']];

            if ($tileContent->isDirty('position')) {
                $this->changePosition(TileContent::class, $tileContent, $input['position']);
            }

            $tileContent->admin_visibility = $input['admin_visibility'];
            $tileContent->user_visibility = $input['user_visibility'];
            $success &= $tileContent->save();
        }

        return LogService::update($success, [
            'tileContent' => TileContent::where('id', $input['id'])->first()->toArray
        ]);
    }

    public function destroy(Request $request) {
        $input = $request->all();
        $validation = new TileContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = TileContent::where('shared_id', $input['shared_id'])
            ->delete();

        return LogService::delete($success > 0);
    }
}
