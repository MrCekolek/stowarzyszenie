<?php

namespace App\Http\Requests;

class TileContentRequest extends FormRequest {
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
            'type' => 'required',
            'tile_id' => 'required|exists:tile_contents',
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:tile_contents'
        ];
    }
}
