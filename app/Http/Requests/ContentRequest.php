<?php

namespace App\Http\Requests;

class ContentRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
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
            'tile_content_id' => 'required|exists:contents',
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:contents'
        ];
    }
}
