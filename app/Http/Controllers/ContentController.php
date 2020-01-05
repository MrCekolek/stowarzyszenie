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

        $content = new Content();
        $content->shared_id = Content::max('shared_id') + 1;
        $content->value_pl = $input['value_pl'];
        $content->value_en = $input['value_en'];
        $content->value_ru = $input['value_ru'];
        $content->selected = $input['selected'];
        $content->position = Content::max('position') + 1;
        $content->tile_content_id = $input['tile_content_id'];
        $content->tile_content_shared_id = $input['tile_content_shared_id'];
        $success = $content->save();

        CreateContentJob::dispatch(
            $content->shared_id,
            $content->name_pl,
            $content->name_en,
            $content->name_ru,
            $content->position,
            $input['tile_content_id'],
            $input['tile_content_shared_id']
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
            $content->name_pl = $input['name_pl'];
            $content->name_en = $input['name_en'];
            $content->name_ru = $input['name_ru'];

            if ($content->isDity('position')) {
                $this->changePosition(Content::class, $content, $input['position']);
            }

            $content->admin_visibility = $input['admin_visibility'];
            $content->user_visibility = $input['user_visibility'];
            $success &= $content->save();
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

        $success = Content::where('shared_id', $input['shared_id'])
            ->delete();

        return LogService::delete($success > 0);
    }
}
