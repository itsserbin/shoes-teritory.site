<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductsPhotoRepository;
use App\Services\UploadImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    private $uploadImagesService;
    private $productsPhotoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->uploadImagesService = app(UploadImageService::class);
        $this->productsPhotoRepository = app(ProductsPhotoRepository::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadPreview(Request $request): mixed
    {
        try {
            $path = $this->uploadImagesService->uploadCategoryPreview($request->all());
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->returnResponse([
                'success' => false,
            ], 400);
        }

        return $this->returnResponse([
            'success' => true,
            'url' => $path,
        ]);
    }

    public function uploadBannerImage(Request $request): JsonResponse
    {
        try {
            $path = $this->uploadImagesService->uploadBannerImage($request->all());
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->returnResponse([
                'success' => false,
            ], 400);
        }

        return $this->returnResponse([
            'success' => true,
            'url' => $path,
        ]);
    }

    public function uploadProductImages(Request $request)
    {
        $path = $this->uploadImagesService->uploadProductImages($request->all());
//        try {
//            $path = $this->uploadImagesService->uploadProductImages($request->all());
//        } catch (\Throwable $exception) {
//            Log::error($exception->getMessage());
//
//            return $this->returnResponse([
//                'success' => false,
//            ], 400);
//        }

        return $this->returnResponse([
            'success' => true,
            'url' => $path,
        ]);
    }

    public function destroyImage($id): JsonResponse
    {
        $result = $this->productsPhotoRepository->destroyImage($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

}
