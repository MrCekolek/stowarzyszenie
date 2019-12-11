<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::all()->each(function ($user) {
            $user['name'] = $user->getName();
        });

        return LogService::read(true, [
            'users' => $users->toArray()
        ]);
    }

    public function emailExist(Request $request) {
        $input = $request->all();

        $success = empty(User::loginEmail($input['email'])->first());

        return response()->json([
            'success' => $success
        ]);
    }
}

