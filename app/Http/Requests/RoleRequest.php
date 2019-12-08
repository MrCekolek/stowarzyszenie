<?php

namespace App\Http\Requests;

class RoleRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'create':
                $this->checkCreate();

                break;

            case 'destroy':
                $this->checkDestroy($input['id']);

                break;
        }

        parent::__construct($input);
    }

    protected function checkCreate() {
        $this->rules = [
            'name' => 'required|unique:roles'
        ];
    }

    protected function checkDestroy($id) {
        $this->rules = [
            'id' => 'required|exists:roles'
        ];
    }
}
