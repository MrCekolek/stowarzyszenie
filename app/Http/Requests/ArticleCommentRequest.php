<?php

namespace App\Http\Requests;

class ArticleCommentRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'index':
                $this->checkIndex();

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
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }

    public function checkCreate() {
        $this->rules = [
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }

    public function checkUpdate() {
        $this->checkCreate();
    }

    public function checkDestroy() {
        $this->rules = [
            'user_id' => 'required|exists:users,id',
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }
}
