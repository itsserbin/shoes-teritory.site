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

    public function uploadCategoryPreview($data)
    {
        $preview = $data['preview'];
        $filename = $preview->getClientOriginalName();

        $root = $_SERVER["DOCUMENT_ROOT"];

        $dir1 = $root . '/storage/category/';

        if (!file_exists($dir1)) {
            mkdir($dir1, 0755, true);
        }

        Image::make($preview)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/category/' . $filename));

        return asset('/storage/category/' . $filename);
    }

    public function uploadBannerImage($data)
    {
        $preview = $data['banner'];
        $filename = $preview->getClientOriginalName();

        $root = $_SERVER["DOCUMENT_ROOT"];

        $dir1 = $root . '/storage/banners/';

        if (!file_exists($dir1)) {
            mkdir($dir1, 0755, true);
        }

        Image::make($preview)->save(public_path('storage/banners/' . $filename));

        return asset('/storage/banners/' . $filename);
    }

    public function uploadProductImages($data)
    {
        $image = $data['image'];
        $filename = $image->getClientOriginalName();

        $root = $_SERVER["DOCUMENT_ROOT"];

        $dir = $root . '/storage/products/55/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        Image::make($image)->save('storage/products/' . $filename);


        $dir1 = $root . '/storage/products/55/';

        if (!file_exists($dir1)) {
            mkdir($dir1, 0755, true);
        }

        Image::make($image)->resize(55, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/products/55/' . $filename));

        $dir2 = $root . '/storage/products/350/';

        if (!file_exists($dir2)) {
            mkdir($dir2, 0755, true);
        }

        Image::make($image)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/products/350/' . $filename));

        $dir3 = $root . '/storage/products/500/';

        if (!file_exists($dir3)) {
            mkdir($dir3, 0755, true);
        }

        Image::make($image)->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/products/500/' . $filename));

        return $filename;
    }
}
