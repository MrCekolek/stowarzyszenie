<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ImageController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ImageController extends Controller {
    use UploadFile;

    /**
     * @OA\Post(
     *     path="/image/upload",
     *     tags={"image"},
     *     summary="Upload image",
     *     operationId="ImageControllerCreate",
     *     @OA\Parameter(
     *         name="file",
     *         in="query",
     *         description="Upload file",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function create(Request $request) {
        $input = $request->all();

        $validation = new ImageRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        $folder  = '/uploads/images/editors';

        return [
            'status' => true,
            'originalName' => $name,
            'generatedName' => $name,
            'msg' => 'Image upload successful',
            'imageUrl' => config('app.back_url') . '/' . $this->uploadOne($image, $folder, 'public', $name)
        ];
    }
}
