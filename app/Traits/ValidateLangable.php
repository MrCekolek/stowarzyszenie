<?php

namespace App\Traits;

trait ValidateLangable {
    private static $langs = [
        'pl',
        'en',
        'ru'
    ];

    public static function validateLang($lang) {
        if ($lang === '') {
            return 'en';
        }

        if (!in_array($lang, self::$langs, true)) {
            return 'en';
        }

        return $lang;
    }
}
