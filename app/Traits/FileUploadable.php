<?php

namespace App\Traits;

use App\Services\ErrorService;
use App\Services\FileUpload;
use Illuminate\Support\Arr;

trait FileUploadable {
    protected function fileUpload(Request $request, array $input, $inputName, $outputName = null) {
        $file = $request->file($inputName);
        $rand = Str::random();

        if (!$outputName) {
            $outputName = $inputName;
        }
        if (!empty($file)) {
            $fileUpload = (new FileUpload())->uploadFile($file, $rand, $rand, $outputName);
            $input = array_merge($input, Arr::except($fileUpload, ['success']));

            if (!$fileUpload['success']) {
                return ErrorService::failFileUpload();
            }
        }

        return $input;
    }
}
