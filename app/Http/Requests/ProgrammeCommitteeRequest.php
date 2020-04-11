<?php

namespace App\Http\Requests;

class ProgrammeCommitteeRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'index':
                $this->checkIndex();

                break;

            case 'create':
                $this->checkCreate();

                break;

            case 'createMulti':
                $this->checkCreateMulti();

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

    public function checkIndex() {
        $this->rules = [
            'conference_id' => 'required|exists:conferences,id'
        ];
    }

    public function checkCreate() {
        $this->rules = [
            'user_id' => 'required|exists:users,id',
            'conference_id' => 'required|exists:conferences,id'
        ];
    }

    public function checkCreateMulti() {
        $this->rules = [
            'users.*.id' => 'required|exists:users,id',
            'conference_id' => 'required|exists:conferences,id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
    }

    public function checkDestroy() {
        $this->checkCreate();
    }
}
