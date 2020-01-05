<?php

namespace App\Http\Requests;

class ContentRequest extends FormRequest {
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
            'value_pl' => 'required',
            'value_en' => 'required',
            'value_ru' => 'required',
            'tile_content_id' => 'required|exists:tile_contents,id',
            'tile_content_shared_id' => 'required|exists:tile_contents,shared_id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:contents',
            'shared_id' => 'required|exists:contents',
            'selected' => 'required',
            'position' => 'required',
            'admin_visibility' => 'required|in:true,false',
            'user_visibility' => 'required|in:true,false',
        ]);
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:contents',
            'shared_id' => 'required|exists:contents',
        ];
    }
}
