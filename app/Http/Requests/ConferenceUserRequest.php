<?php

namespace App\Http\Requests;

class ConferenceUserRequest extends FormRequest {
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
            'user_id' => 'required|exists:users',
            'conference_id' => 'required|exists:conferences',
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'status' => 'required'
        ]);
    }

    public function checkDestroy() {
        $this->checkCreate();
    }
}
