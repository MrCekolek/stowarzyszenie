<?php

namespace App\Http\Requests;

class RoleUserRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'getUsers':
                $this->checkGetUsers();

                break;

            case 'getUsersNot':
                $this->checkGetUsersNot();

                break;

            case 'getRoles':
                $this->checkGetRoles();

                break;

            case 'create':
                $this->checkCreate();

                break;

            case 'destroy':
                $this->checkDestroy();

                break;
        }

        parent::__construct($input);
    }

    protected function checkGetUsers() {
        $this->rules = [
            'role_id' => 'required|exists:roles,id'
        ];
    }

    protected function checkGetUsersNot() {
        $this->rules = [
            'role_id' => 'required|exists:roles,id'
        ];
    }

    protected function checkGetRoles() {
        $this->rules = [
            'user_id' => 'required|exists:users,id'
        ];
    }

    protected function checkCreate() {
        $this->rules = [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ];
    }

    protected function checkDestroy() {
        $this->rules = [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
