<?php

namespace App\Http\Requests;

class HomeNavigationRequest extends FormRequest {
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

    public function checkCreate() {
        $this->rules = [
            'status' => 'required',
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'link' => 'required',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function checkShow() {
        $this->rules = [
            'id' => 'required|exists:home_navigations'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:home_navigations'
        ]);
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:home_navigations'
        ];
    }
}
