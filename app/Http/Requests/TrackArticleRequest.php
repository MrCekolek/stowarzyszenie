<?php

namespace App\Http\Requests;

class TrackArticleRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'index':
                $this->checkIndex();

                break;

            case 'show':
                $this->checkShow();

                break;

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

    public function checkIndex() {
        $this->rules = [
            'track_id' => 'required|exists:tracks,id',
        ];
    }

    public function checkShow() {
        $this->rules = [
            'id' => 'required|exists:track_articles'
        ];
    }

    public function checkCreate() {
        $this->rules = [
            'title_pl' => 'required',
            'title_en' => 'required',
            'title_ru' => 'required',
            'abstract_pl' => 'required',
            'abstract_en' => 'required',
            'abstract_ru' => 'required',
            'user_id' => 'required|exists:users,id',
            'track_id' => 'required|exists:tracks,id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
        $this->rules = array_merge($this->rules, [
                'id' => 'required|exists:track_articles',
                'status' => 'required'
            ]
        );
    }

    public function checkDestroy() {
        $this->rules = [
            'id' => 'required|exists:track_articles'
        ];
    }
}
