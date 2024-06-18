<?php

namespace App\Traits\File;

use Illuminate\Support\Facades\Storage;

trait DeleteFile
{
    function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }
}
