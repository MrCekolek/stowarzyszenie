<?php

namespace App\Http\Requests;

class RoleUserRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'getUsers':
                $this->checkGetUsers();

                break;

            case 'getUsersNotInTrack':
                $this->checkGetUsersNotInTrack();

                break;

            case 'getUsersNot':
                $this->checkGetUsersNot();

                break;

            case 'getRoles':
                $this->checkGetRoles();

                break;

            case 'getOtherRoles':
                $this->checkGetOtherRoles();

                break;

            case 'create':
                $this->checkCreate();

                break;

            case 'createMulti':
                $this->checkCreateMulti();

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

    protected function checkGetUsersNotInTrack() {
        $this->rules = [
            'track_id' => 'required|exists:tracks,id',
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

    protected function checkGetOtherRoles() {
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

    protected function checkCreateMulti() {
        $this->rules = [
            'roles.*.id' => 'required|exists:roles,id',
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
