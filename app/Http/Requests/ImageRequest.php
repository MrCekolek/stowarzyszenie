<?php

namespace App\Http\Requests;

class ImageRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'create':
                $this->checkCreate();

                break;
        }

        parent::__construct($input);
    }

    public function checkCreate() {
        $this->rules = [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];
    }
}
