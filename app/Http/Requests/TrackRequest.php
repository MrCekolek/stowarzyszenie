<?php

namespace App\Http\Requests;

class TrackRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'index':
                $this->checkIndex();

                break;

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

    protected function checkIndex() {
        $this->rules = [
            'conference_id' => 'required|exists:conferences,id'
        ];
    }

    protected function checkCreate() {
        $this->checkIndex();
        $this->rules = array_merge($this->rules, [
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'colour' => 'required',
            'interest_id' => 'required|exists:interests,id'
        ]);
    }

    protected function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:tracks'
        ]);
    }

    protected function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:tracks'
        ];
    }
}