<?php

namespace App\Http\Requests;

class TranslationRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'getTranslation':
                $this->checkGetTranslation();

                break;

            case 'create':
                $this->checkCreate();

                break;

            case 'update':
                $this->checkUpdate();

                break;

            case 'destroy':
                $this->checkDestroy();

                break;
        }

        parent::__construct($input);
    }

    public function checkCreate() {
        $this->rules = [
            'translation_key' => 'required',
            'translation_pl' => 'required',
            'translation_en' => 'required',
            'translation_ru' => 'required'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
    }

    public function checkGetTranslation() {
        $this->rules = [
            'name' => 'required'
        ];
    }
}
