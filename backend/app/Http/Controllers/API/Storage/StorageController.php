<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\StoreRequest;
use App\Services\StorageService;

class StorageController extends Controller
{
    private $storageService;

    public function __construct(StorageService $storageService) {
        $this->storageService = $storageService;
    }
    /**
     * @OA\Post(
     *      path="/storage/store-file",
     *      operationId="postStoreFile",
     *      tags={"Storage"},
     *      summary="Store File",
     *      description="Store File",
     *      @OA\Response(
     *          response=200,
     *          description="URL File Store",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function storeFile(StoreRequest $request)
    {
        $file = $request->file('file');
        $fileName = $this->storageService->uploadFile($file);
        return response()->json([
            'url' => env('APP_URL').'storage/'.$fileName
        ], 200);
    }
}
