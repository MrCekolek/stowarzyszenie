<?php

namespace App\Http\Requests;

class RoleRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'create':
                $this->checkCreate();

                break;

            case 'show':
                $this->checkShow();

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

    protected function checkShow() {
        $this->rules = [
            'id' => 'required|exists:roles'
        ];
    }

    protected function checkCreate() {
        $this->rules = [
            'name_pl' => 'required|unique:roles',
            'name_en' => 'required|unique:roles',
            'name_ru' => 'required|unique:roles'
        ];
    }

    protected function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:roles'
        ]);
    }

    protected function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:roles'
        ];
    }
}
