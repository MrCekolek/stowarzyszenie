<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile {
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null) {
        $name = !is_null($filename) ? $filename : Str::random(25);

        return $uploadedFile->storeAs($folder, pathinfo($name, PATHINFO_FILENAME) . time() . '.' . $uploadedFile->getClientOriginalExtension(), $disk);
    }
}
