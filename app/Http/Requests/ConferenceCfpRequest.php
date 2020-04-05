<?php

namespace App\Http\Requests;

class ConferenceCfpRequest extends FormRequest {
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
    }

    protected function checkUpdate() {
        $this->checkIndex();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:conference_cfps'
        ]);
    }

    protected function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:conference_cfps'
        ];
    }
}
