<?php

namespace App\Http\Requests;

class TileRequest extends FormRequest {
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
            'name' => 'required',
            'portfolio_tab_id' => 'required|exists:tiles',
        ];
    }

    public function checkUpdate() {
        $this->rules = [
            'name' => 'required',
            'position' => 'required'
        ];
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:tiles'
        ];
    }
}
