<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestUserRequest;
use App\Models\InterestUser;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;

class InterestUserController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(User $user) {
        $interestUsers = InterestUser::whereUserId($user->id)
            ->toArray();

        return LogService::read(true, [
            'interestUsers' => $interestUsers
        ]);
    }

    public function update(Request $request, User $user) {
        $input = $request->all();
        $validation = new InterestUserRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return LogService::update();
    }
}
