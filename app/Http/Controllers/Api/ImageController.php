<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Files\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function upload(Request $request, $user_id)
    {
        $status = $this->fileService->uploadFile($request, $user_id);
        if ($status['status']) {
            return $this->respond('image uploaded successfully', Response::HTTP_CREATED, ['url' => $status['url']]);
        }
        return $this->respond($status['message'], Response::HTTP_NOT_IMPLEMENTED);
    }
}
