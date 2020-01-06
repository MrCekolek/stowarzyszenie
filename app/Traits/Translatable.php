<?php

namespace App\Traits;

use App\Jobs\TranslateJob;
use JWTAuth;

trait Translatable {
    protected static function languages() {
        return [
            'pl',
            'en',
            'ru'
        ];
    }

    public function translate($source, $expression, $model, $field) {
        foreach (self::languages() as $language) {
            if ($source !== $language) {
                TranslateJob::dispatchNow($source, $language, $expression, $model, $field . '_' . $language);
            } else {
                $model->{'name_' . $source} = $expression;
                $model->save();
            }
        }
    }
}
