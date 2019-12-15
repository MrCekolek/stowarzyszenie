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
        $interests = Interest::all()
            ->toArray();

        return LogService::read(true, [
            'interests' => $interests
        ]);
    }

    public function create(Request $request) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $interest = Interest::create(),
            'name'
        );

        return LogService::create($interest->exists(), [
            'interest' => $interest->toArray()
        ]);
    }

    public function update(Request $request, Interest $interest) {
        $input = $request->all();
        $validation = new InterestRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            Interest::whereId($interest->id),
            'name'
        );

        return LogService::update();
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
