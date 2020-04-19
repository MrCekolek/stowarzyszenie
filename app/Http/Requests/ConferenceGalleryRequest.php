<?php

namespace App\Http\Requests;

class ConferenceGalleryRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'index':
                $this->checkIndex();

                break;

            case 'create':
                $this->checkCreate();

                break;

            case 'destroy':
                $this->checkDestroy();

                break;

            case 'destroyMulti':
                $this->checkDestroyMulti();

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
        $this->rules = [
            'file' => 'required',
            'conference_id' => 'required|exists:conferences,id'
        ];
    }

    protected function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:conference_galleries'
        ];
    }

    protected function checkDestroyMulti() {
        $this->rules = [
            'conference_id' => 'required|exists:conferences,id'
        ];
    }
}
