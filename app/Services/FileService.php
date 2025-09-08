<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FileService
{

    public function handleFileUpload($file)
    {
        try {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            $filename = Str::uuid() . '.' . $extension;
            $path = $file->storeAs('files', $filename, 'public');

            $file = File::create([
                'original_name' => $originalName,
                'filename'      => $filename,
                'path'          => $path,
                'mime_type'     => $mimeType,
                'extension'     => $extension,
                'size'          => $size,
                'disk'          => 'public',
                'category'      => 'product_category',
                'uploaded_by'   => Auth::id() ?? null,
                'is_public'     => true,
            ]);
        }catch(\Exception $e){
            Log::error('File upload error: '.$e->getMessage());
            $file = null;
        }

        return $file ? $file->id : null;
    }
}
