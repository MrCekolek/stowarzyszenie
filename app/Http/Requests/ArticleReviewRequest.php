<?php

namespace App\Http\Requests;

class ArticleReviewRequest extends FormRequest {
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
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function checkShow() {
        $this->rules = [
            'id' => 'required|exists:article_reviews'
        ];
    }

    public function checkCreate() {
        $this->rules = [
            'user_id' => 'required|exists:users,id',
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }

    public function checkUpdate() {
        $this->rules = [
            'mark' => 'required',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }

    public function checkDestroy() {
        $this->rules = [
            'user_id' => 'required|exists:users,id',
            'track_article_id' => 'required|exists:track_articles,id'
        ];
    }
}
