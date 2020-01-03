<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestRequest;
use App\Models\Interest;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class InterestController extends Controller {
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index() {
        return LogService::read(true, [
            'interests' => Interest::all()->toArray()
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $interest = new Interest();
        $interest->name_pl = $input['name_pl'];
        $interest->name_en = $input['name_en'];
        $interest->name_ru = $input['name_ru'];
        $saved = $interest->save();

        return LogService::create($saved, [
            'interest' => $interest->toArray()
        ]);
    }

    public function update(Request $request, Interest $interest) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $interest->update([
            'name_pl' => $input['name_pl'],
            'name_en' => $input['name_en'],
            'name_ru' => $input['name_ru']
        ]);

        return LogService::update(true, [
            'interest' => $interest->toArray()
        ]);
    }

    public function destroy(Request $request, Interest $interest) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'destroy');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $success = Interest::destroy($interest->id);

        return LogService::delete($success);
    }
}
