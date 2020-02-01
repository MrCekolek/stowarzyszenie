<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Models\Translation;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

/**
 * Class TranslationController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TranslationController extends Controller
{
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/translation/get",
     *     tags={"translation"},
     *     summary="Gets translations",
     *     operationId="TranslationControllerGetTranslation",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Phrase to translate in users language",
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
    public function getTranslation(Request $request) {
        $input = $request->all();

        $validation = new TranslationRequest($input, 'getTranslation');

        if ($validation->fails()) {
            return $validation->failResponse();
        }
        
        Translation::truncate();

        $this->translate(
            auth()->user()->preferenceUser()->first()->lang,
            $input['name'],
            $translation = new Translation(),
            'name'
        );

        return LogService::read(true, [
            'translation' => $translation
        ]);
    }
}
