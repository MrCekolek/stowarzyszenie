<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class UserController extends Controller {
    /**
     * @OA\Post(
     *     path="/user/get",
     *     tags={"authentication"},
     *     summary="Gets all users",
     *     operationId="UserControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'users' => User::all()->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/email/exist",
     *     tags={"authentication"},
     *     summary="Check if users email exists",
     *     operationId="UserControllerEmailExist",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function emailExist(Request $request) {
        $input = $request->all();

        return response()->json([
            'success' => empty(User::where('login_email', $input['email'])->first())
        ]);
    }
}

