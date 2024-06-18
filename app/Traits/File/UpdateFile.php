<?php

namespace App\Traits\File;

trait UpdateFile
{
    use DeleteFile, UploadFile;
    function updateFile($oldPath, $request, $key, $folder)
    {
        $this->deleteFile(
            path: $oldPath
        );

        $path = $this->uploadFile(
            request: $request,
            key: $key,
            folder: $folder
        );

        return $path;
    }//end updateFile

}//end UpdateFile
