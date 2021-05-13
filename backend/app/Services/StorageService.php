<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function uploadFile($file)
    {
        $fileName = 'images/'.time().'_'.$file->getClientOriginalName();
        Storage::disk('public')->put($fileName, file_get_contents($file));
        return $fileName;
    }
}
