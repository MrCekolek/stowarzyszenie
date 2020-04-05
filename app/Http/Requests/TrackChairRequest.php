<?php

namespace App\Http\Requests;

class TrackChairRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'create':
                $this->checkCreate();

                break;

            case 'destroy':
                $this->checkDestroy();

                break;
        }

        parent::__construct($input);
    }

    public function checkCreate() {
        $this->rules = [
            'user_id' => 'required|exists:users,id',
            'track_id' => 'required|exists:tracks,id',
        ];
    }

    public function checkDestroy() {
        $this->checkCreate();
    }
}