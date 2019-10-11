<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index(Request $request) {
        $inputs = $request->all();

        $users = User::firstLastName($inputs['searchTyped'])->get();

        return response()->json([
            'users' => $users
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
