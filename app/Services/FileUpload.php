<?php

namespace App\Services;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUpload {

    /**
     * @var string
     */
    protected $publicPath;

    /**
     * @var string
     */
    protected $urlPath;

    /**
     * @var string
     */
    protected $uploadDir = 'uploads';

    public function __construct() {
        $this->publicPath = public_path();
    }

    /**
     * @param $fileElem
     * @param $id
     * @param $name
     * @param $output
     * @return array
     */
    public function uploadFile($fileElem, $id, $name, $output) {
        $success = false;
        $hash = md5(sprintf('%s.%s+%s', $id, $name, time()));
        $destinationPath = sprintf('%s/%s/%s', $this->uploadDir, substr($hash, 0, 2), $hash);
        $newName = sprintf('%s.%s', Str::random(8), $fileElem->getClientOriginalExtension());

        $file = sprintf('/%s/%s', $destinationPath, $newName);

        try {
            $fileElem->move(sprintf('%s/%s', $this->publicPath, $destinationPath), $newName);
        } catch (FileException $e) {
            $error = $e->getMessage();
            return compact('success', 'error');
        }
        $success = true;
        return ['success' => $success, $output => $file];
    }

    /**
     * @return string
     */
    public function getUrlPath() {
        return $this->urlPath;
    }

    /**
     * @param string $dir
     */
    public function setDir($dir) {
        $this->uploadDir = $dir;
    }

    /**
     * @return string
     */
    public function getDir() {
        return $this->uploadDir;
    }
}
