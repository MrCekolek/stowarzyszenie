<?php

namespace App\Http\Requests;

class ConferenceRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'create':
                $this->checkCreate();

                break;

            case 'show':
                $this->checkShow();

                break;

            case 'getUserArticles':
                $this->getUserArticles();

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

    protected function checkCreate() {
    $this->rules = [
        'name_pl' => 'required',
        'name_en' => 'required',
        'name_ru' => 'required',
        'place_pl' => 'required',
        'place_en' => 'required',
        'place_ru' => 'required'
    ];
}

    protected function checkShow() {
        $this->rules = [
            'id' => 'required|exists:conferences'
        ];
    }

    protected function getUserArticles() {
        $this->rules = [
            'user_id' => 'required|exists:users,id'
        ];
    }

    protected function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:conferences'
        ]);
    }

    protected function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:conferences'
        ];
    }
}
