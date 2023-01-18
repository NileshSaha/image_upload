<?php

namespace App\Services\Files;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function uploadFile($request, $user_id)
    {
        $uploadPath = 'files/' ;
        $image = $request->file('image');

        $randomString = Str::random(16);

        $imgFile      = "{$randomString}-" . time() . '.'. $image->getClientOriginalExtension();
        $imgPath      = "{$uploadPath}{$imgFile}";

        try {
            Storage::disk('local')->put($imgPath, file_get_contents($image));
            Image::create([
                'user_id' => $user_id,
                'image_original_name' => $image->getClientOriginalName(),
                'image_updated_name' => $imgPath,
            ]);
            return ['status' => true, 'image' => Storage::disk('local')->url($imgPath)];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
