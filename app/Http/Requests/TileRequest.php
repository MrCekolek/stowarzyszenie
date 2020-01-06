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
        }

        parent::__construct($input);
    }

    public function checkCreate() {
        $this->rules = [
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'portfolio_tab_id' => 'required|exists:portfolio_tabs,id',
            'portfolio_tab_shared_id' => 'required|exists:portfolio_tabs,shared_id'
        ];
    }

    public function checkUpdate() {
        $this->rules = [
            'id' => 'required|exists:tiles',
            'shared_id' => 'required|exists:tiles',
            'name_pl' => 'required',
            'name_en' => 'required',
            'name_ru' => 'required',
            'position' => 'required',
            'admin_visibility' => 'required|in:true,false',
            'user_visibility' => 'required|in:true,false'
        ];
    }

    public function checkDestroy() {
        $this->rules = [
            'shared_id' => 'required|exists:tiles',
            'portfolio_tab_id' => 'required|exists:portfolio_tabs,id'
        ];
    }
}
