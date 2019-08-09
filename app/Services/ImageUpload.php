<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    /**
     * Upload the given file(s) to the storage.
     *
     * @param   UploadedFile  $file  The file
     * @return  string File disk path.
     */
    public function upload(UploadedFile $file) : string
    {
        $path = $file->store(config('devsquad.storage_path'), [
            'disk' => config('devsquad.storage_disk'),
            'visibility' => 'public'
        ]);
        
        return Storage::disk(config('devsquad.storage_disk'))->url($path);
    }
}
