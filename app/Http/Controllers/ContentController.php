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

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $content = Content::create([
                'value' => $input['value'],
                'tile_content_id' => $input['tile_content_id']
            ]),
            'name'
        );

        return LogService::create($content->exists(), [
            'content' => $content->toArray()
        ]);
    }

    public function update(Request $request, Content $content) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['value'],
            $content,
            'value'
        );

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
