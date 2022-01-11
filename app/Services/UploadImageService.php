<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class UploadImageService
 * @package App\Services
 */
class UploadImageService
{

    /**
     * Загрузчик превью товара.
     *
     * @param $data
     * @return string
     */
    public function uploadCategoryPreview($data)
    {
        $preview = $data['preview'];
        $filename = $preview->getClientOriginalName();

        Image::make($preview)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('storage/preview/' . $filename);

        return asset('/storage/preview/' . $filename);
    }

    public function uploadProductImages($data)
    {
        $image = $data['image'];
        $filename = $image->getClientOriginalName();

        Image::make($image)->resize(55, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('storage/products/55/' . $filename);

        Image::make($image)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('storage/products/350/' . $filename);

        Image::make($image)->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save('storage/products/500/' . $filename);

        Image::make($image)->save('storage/products/' . $filename);

        return $filename;
    }
}
