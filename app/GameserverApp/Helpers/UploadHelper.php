<?php

namespace App\GameserverApp\Helpers;

use App\GameserverApp\Exceptions\UploadExceededFileSizeLimitException;
use App\GameserverApp\Exceptions\UploadMimeTypeNotAcceptedException;
use Illuminate\Http\Request;

class UploadHelper
{
    public static function validate(Request $request, $key)
    {
        if(!$request->hasFile($key)) {

            if($request->has($key)) {
                throw new UploadExceededFileSizeLimitException();
            }

            return null;
        }

        $file = $request->file($key);

        if($file->getSize() > self::uploadSizeLimit()) {
            throw new UploadExceededFileSizeLimitException();
        }

        if(!in_array($file->getMimeType(), self::acceptedMimeTypes())) {
            throw new UploadMimeTypeNotAcceptedException();
        }

        return $file;
    }

    public static function uploadSizeLimit()
    {
        return config('gameserverapp.upload.limit')  * 1000; //size in KB
    }

    public static function acceptedMimeTypes()
    {
        return [
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/gif'
        ];
    }
}

