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
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required'
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
