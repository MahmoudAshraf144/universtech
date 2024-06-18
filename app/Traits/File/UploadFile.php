<?php

namespace App\Traits\File;

use Illuminate\Http\Request;

trait UploadFile
{

    function uploadFile(Request $request, $key, $folder)
    {
        $path = $request->file($key)->store($folder,'public');
        return $path;
    }
}
