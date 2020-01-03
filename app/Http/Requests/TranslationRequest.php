<?php

namespace App\Http\Requests;

class TranslationRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'getTranslation':
                $this->checkGetTranslation();

                break;
        }

        parent::__construct($input);
    }

    public function checkGetTranslation() {
        $this->rules = [
            'name' => 'required'
        ];
    }
}
