<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function emailExist(Request $request) {
        $input = $request->all();

        $success = empty(User::loginEmail($input['email'])->first());

        return response()->json([
            'success' => $success
        ]);
    }
}
