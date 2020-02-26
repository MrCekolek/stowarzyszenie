<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Models\Translation;
use App\Services\LogService;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class TranslationController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class TranslationController extends Controller {
    use Translatable;

    private $basePath,
        $pl,
        $en,
        $ru,
        $translations;

    public function __construct() {
        $this->middleware('auth:api');

        if (Route::current()->uri() !== 'api/translation/get') {
            $this->basePath = __DIR__ . '/../../../front/src/assets/i18n/';

            $this->pl = json_decode(file_get_contents($this->basePath . 'pl.json'), true);
            $this->en = json_decode(file_get_contents($this->basePath . 'en.json'), true);
            $this->ru = json_decode(file_get_contents($this->basePath . 'ru.json'), true);
        }
    }

    /**
     * @OA\Post(
     *     path="/translation",
     *     tags={"translation"},
     *     summary="Gets translations files in json format",
     *     operationId="TranslationControllerIndex",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() {
        return LogService::read(true, [
            'translations' => $this->arrayMergeRecursive()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/translation/create",
     *     tags={"translation"},
     *     summary="Add translations to json files",
     *     operationId="TranslationControllerCreate",
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="JSON key",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_ru",
     *         in="query",
     *         description="Translation in russian language",
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

        $validation = new TranslationRequest($input, 'create');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        if ($this->translationExists($this->pl, $input['translation_key'])) {
            return LogService::read(false, [
                'message' => 'STOWARZYSZENIE.SERVER.CUSTOM.CONTROLLERS.ERROR.TRANSLATION_KEY_EXISTS'
            ]);
        }

        $translationDivided = explode('.', $input['translation_key']);
        $translationDividedShifted = [];

        while (!$this->translationExists($this->pl, implode('.', $translationDivided))) {
            array_unshift($translationDividedShifted, array_pop($translationDivided));
        }

        $this->saveToJSON(
            $input,
            $translationDivided,
            $translationDividedShifted
        );

        return LogService::create(true, [
            'translations' => $this->arrayMergeRecursive()
        ]);
    }

    private function translationExists($array, $translationKey) {
        $translationExploded = explode('.', $translationKey);
        $translationShifted = array_shift($translationExploded);

        if (array_key_exists($translationShifted, $array)) {
            if (empty($translationExploded)) {
                return true;
            }

            return $this->translationExists($array[$translationShifted], implode('.', $translationExploded));
        }

        return false;
    }

    private function saveToJSON($input, $translationDivided, $translationDividedShifted) {
        $this->changeTranslations(
            $translationDivided,
            $translationDividedShifted,
            $input['translation_pl'],
            $input['translation_en'],
            $input['translation_ru'],
            $this->pl,
            $this->en,
            $this->ru
        );

        $this->saveToFile($this->pl,'pl.json');
        $this->saveToFile($this->en, 'en.json');
        $this->saveToFile($this->ru, 'ru.json');
    }

    private function saveToFile($translations, $fileName) {
        $file = fopen($this->basePath . $fileName, 'w');
        fwrite(
            $file,
            json_encode(
                $translations,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            )
        );
        fclose($file);
    }

    private function changeTranslations(
        $translationDivided,
        $translationDividedShifted,
        $translationPl,
        $translationEn,
        $translationRu,
        &$pl,
        &$en,
        &$ru
    ) {
        $translationKey = array_shift($translationDivided);

        if ($translationKey !== null) {
            return $this->changeTranslations(
                $translationDivided,
                $translationDividedShifted,
                $translationPl,
                $translationEn,
                $translationRu,
                $pl[$translationKey],
                $en[$translationKey],
                $ru[$translationKey]
            );
        }

        if (count($translationDividedShifted) > 1) {
            $pl[$translationDividedShifted[0]] = [];
            $en[$translationDividedShifted[0]] = [];
            $ru[$translationDividedShifted[0]] = [];

            $translationKey = array_shift($translationDividedShifted);

            return $this->changeTranslations(
                $translationDivided,
                $translationDividedShifted,
                $translationPl,
                $translationEn,
                $translationRu,
                $pl[$translationKey],
                $en[$translationKey],
                $ru[$translationKey]
            );
        }

        $pl[$translationDividedShifted[0]] = $translationPl;
        $en[$translationDividedShifted[0]] = $translationEn;
        $ru[$translationDividedShifted[0]] = $translationRu;

        return $pl;
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

    /**
     * @OA\Post(
     *     path="/translation/update",
     *     tags={"translation"},
     *     summary="Update translations to json files",
     *     operationId="TranslationControllerUpdate",
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="JSON key",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_pl",
     *         in="query",
     *         description="Translation in polish language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_en",
     *         in="query",
     *         description="Translation in english language",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="translation_ru",
     *         in="query",
     *         description="Translation in russian language",
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
    public function update(Request $request) {
        $input = $request->all();

        $validation = new TranslationRequest($input, 'update');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        if (!$this->updateArrayKey($this->pl, $this->en, $this->ru, $input, explode('.', $input['translation_key']))) {
            return LogService::update(false);
        }

        $this->saveToFile($this->pl,'pl.json');
        $this->saveToFile($this->en, 'en.json');
        $this->saveToFile($this->ru, 'ru.json');

        return LogService::update(true, [
            'translations' => $this->arrayMergeRecursive()
        ]);
    }

    private function updateArrayKey(&$arrayPl, &$arrayEn, &$arrayRu, $input, $translationKey) {
        $translationKeyShifted = array_shift($translationKey);

        if (empty($translationKeyShifted)) {
            $arrayPl = $input['translation_pl'];
            $arrayEn = $input['translation_en'];
            $arrayRu = $input['translation_ru'];

            return true;
        }

        if (isset($arrayPl[$translationKeyShifted])) {
            return $this->updateArrayKey($arrayPl[$translationKeyShifted], $arrayEn[$translationKeyShifted], $arrayRu[$translationKeyShifted], $input, $translationKey);
        }

        return false;
    }

    /**
     * @OA\Post(
     *     path="/translation/destroy",
     *     tags={"translation"},
     *     summary="Deleted translations files in json format",
     *     operationId="TranslationControllerDestroy",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function destroy($translationKey) {
        if (!$this->deleteArrayKey($this->pl, $this->en, $this->ru, explode('.', $translationKey))) {
            return LogService::update(false);
        }

        $this->saveToFile($this->pl,'pl.json');
        $this->saveToFile($this->en, 'en.json');
        $this->saveToFile($this->ru, 'ru.json');

        return LogService::update(true, [
            'translations' => $this->arrayMergeRecursive()
        ]);
    }

    private function deleteArrayKey(&$arrayPl, &$arrayEn, &$arrayRu, $translationKey) {
        $translationKeyShifted = array_shift($translationKey);

        if (empty($translationKey)) {
            unset($arrayPl[$translationKeyShifted], $arrayEn[$translationKeyShifted], $arrayRu[$translationKeyShifted]);

            return true;
        }

        if (isset($arrayPl[$translationKeyShifted])) {
            return $this->deleteArrayKey($arrayPl[$translationKeyShifted], $arrayEn[$translationKeyShifted], $arrayRu[$translationKeyShifted], $translationKey);
        }

        return false;
    }

    private function arrayMergeRecursive() {
        return array_merge_recursive(array_merge_recursive($this->pl, $this->en), $this->ru);
    }
}
