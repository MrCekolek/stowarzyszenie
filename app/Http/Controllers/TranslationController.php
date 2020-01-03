<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Models\Translation;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    use Translatable;

    public function __construct() {
        $this->middleware('auth:api');
    }

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
