<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentRequest;
use App\Jobs\CreateContentJob;
use App\Models\Content;
use App\Models\TileContent;
use App\Services\LogService;
use App\Traits\ChangePosition;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class ContentController extends Controller {
    use Translatable,
        ChangePosition;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(TileContent $tileContent) {
        return LogService::read(true, [
            'tiles' =>  Content::where('tile_content_id', $tileContent->id)->get()->toArray()
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        CreateContentJob::dispatch(
            $content = Content::addContent($input, $success),
            $input
        );

        return LogService::create($success, [
            'content' => $content->toArray()
        ]);
    }

    public function update(Request $request) {
        $success = true;
        $input = $request->all();
        $validation = new ContentRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        foreach (Content::where('shared_id', $input['shared_id'])->get() as $content) {
            Content::updateContent($content, $input, $success);
        }

        return LogService::update($success, [
            'content' => Content::where('id', $input['id'])->first()->id
        ]);
    }

    public function destroy(Request $request) {
        $input = $request->all();
        $validation = new ContentRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Content::where('tile_content_shared_id', $input['tile_content_shared_id'])
            ->where('shared_id', $input['shared_id'])
            ->delete();

        self::reindexPositions(Content::class);

        return LogService::delete($success > 0, [
            'contents' => Content::where('tile_content_id', $input['tile_content_id'])->get()->toArray()
        ]);
    }
}
