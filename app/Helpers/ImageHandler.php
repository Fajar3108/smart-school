<?php

namespace App\Helpers;

class ImageHandler {
    public static function store($image, $path, $options)
    {
        return $image->store($path, $options);
    }
}
