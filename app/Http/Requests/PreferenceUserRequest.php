<?php

namespace App\Http\Requests;

class PreferenceUserRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'setLang':
                $this->checkSetLang();

                break;

            case 'updateAvatar':
                $this->checkUpdateAvatar();

                break;
        }

        parent::__construct($input);
    }

    public function checkSetLang() {
        $this->rules = [
            'lang' => 'required|in:en,pl,ru'
        ];
    }

    public function checkUpdateAvatar() {
        $this->rules = [
            'id' => 'required|exists:users',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];
    }
}
