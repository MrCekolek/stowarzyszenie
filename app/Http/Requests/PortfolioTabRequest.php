<?php

namespace App\Http\Requests;

class PortfolioTabRequest extends FormRequest {
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
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'portfolio_id' => 'required|exists:portfolio_tabs'
        ];
    }

    public function checkUpdate() {
        $this->rules = [
            'id' => 'required|exists:portfolio_tabs',
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'position' => 'required'
        ];
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:portfolio_tabs'
        ];
    }
}
