<?php

namespace App\Http\Requests;

class TileContentRequest extends FormRequest {
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
            'type' => 'required',
            'tile_id' => 'required|exists:tiles,id',
            'tile_shared_id' => 'required|exists:tiles,shared_id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
            'id' => 'required|exists:tile_contents',
            'shared_id' => 'required|exists:tile_contents',
            'position' => 'required',
            'admin_visibility' => 'required|in:true,false',
            'user_visibility' => 'required|in:true,false'
        ]);
    }

    public function checkDestroy() {
        $this->rules = [
            'shared_id' => 'required|exists:tile_contents',
            'tile_id' => 'required|exists:tiles,id',
            'tile_shared_id' => 'required|exists:tiles,shared_id'
        ];
    }

    public function checkUpdateVisibility() {
        $this->rules = [
            'id' => 'required|exists:tile_contents',
            'shared_id' => 'required|exists:tile_contents',
            'field' => 'required|in:admin,user',
            'visibility' => 'required|in:true,false'
        ];
    }
}
