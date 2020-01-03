<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentRequest;
use App\Models\Content;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class ContentController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(TileContent $tileContent) {
        $tiles = Content::where('tile_content_id', $tileContent->id)
            ->toArray();

        return LogService::read(true, [
            'tiles' => $tiles
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $content = new Content();
        $content->value_pl = $input['value_pl'];
        $content->value_en = $input['value_en'];
        $content->value_ru = $input['value_ru'];
        $content->tile_content_id = $input['tile_content_id'];
        $saved = $content->save();

        return LogService::create($saved, [
            'content' => $content->toArray()
        ]);
    }

    public function update(Request $request, Content $content) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $content->update([
            'value_pl' => $input['value_pl'],
            'value_en' => $input['value_en'],
            'value_ru' => $input['value_ru']
        ]);
        
        return LogService::update(true, [
            'content' => $content->toArray()
        ]);
    }

    public function destroy(Request $request, Content $content) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Content::destroy($content->id);

        return LogService::delete($success);
    }
}
