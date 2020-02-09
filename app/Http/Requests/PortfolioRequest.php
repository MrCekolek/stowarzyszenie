<?php

namespace App\Http\Requests;

class PortfolioRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'update':
                $this->checkUpdate();

                break;
        }

        parent::__construct($input);
    }

    public function checkUpdate() {
        $this->rules = [
            'id' => 'required|exists:portfolios',
            'description' => 'required'
        ];
    }
}
