<?php

namespace App\Http\Requests;

class TileRequest extends FormRequest {
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

            case 'updateVisibility':
                $this->checkUpdateVisibility();

                break;
        }

        parent::__construct($input);
    }

    public function checkCreate() {
        $this->rules = [
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'admin_visibility' => 'required',
            'user_visibility' => 'required',
            'portfolio_tab_id' => 'required|exists:portfolio_tabs,id',
            'portfolio_tab_shared_id' => 'required|exists:portfolio_tabs,shared_id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
                'id' => 'required|exists:tiles',
                'shared_id' => 'required|exists:tiles',
                'position' => 'required',
                'admin_visibility' => 'required',
                'user_visibility' => 'required'
            ]
        );
    }

    public function checkDestroy() {
        $this->rules = [
            'shared_id' => 'required|exists:tiles',
            'portfolio_tab_id' => 'required|exists:portfolio_tabs,id',
            'portfolio_tab_shared_id' => 'required|exists:portfolio_tabs,shared_id'
        ];
    }

    public function checkUpdateVisibility() {
        $this->rules = [
            'id' => 'required|exists:tiles',
            'shared_id' => 'required|exists:tiles',
            'field' => 'required|in:admin,user',
            'visibility' => 'required'
        ];
    }
}
