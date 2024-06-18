<?php

namespace App\Traits\File;

trait UploadManyFile
{

    function uploadManyFile($request, $key, $folder)
    {
        $images = $request->file($key);
        $array = [];

        foreach ($images as $image) {
            $path = $image->store($folder, 'public');
            $array[] = $path;
        }

        return $array;
    } //end uploadManyFile

} //end UploadManyFile
