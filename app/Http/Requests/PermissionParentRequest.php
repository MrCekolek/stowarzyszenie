<?php

namespace App\Http\Requests;

class PermissionParentRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'rolePermissions':
                $this->checkRolePermissions();

                break;
        }

        parent::__construct($input);
    }

    public function checkRolePermissions() {
        $this->rules = [
            'id' => 'required|exists:roles'
        ];
    }
}
