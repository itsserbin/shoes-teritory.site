<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;

class UpdateProductsPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $result_products = DB::table('products')
            ->select('id', 'preview')
            ->get();


        foreach ($result_products as $item) {
            $value = '/' . $item->preview;
            DB::table('products')->where('id', $item->id)->update(['preview' => $value]);
        }

        $result_products_photo = DB::table('products_photos')
            ->select('id', 'image')
            ->get();


        foreach ($result_products_photo as $item) {

            if (str_contains($item->image, '/')) {
                $arr = explode('/', $item->image);
                $result = array_pop($arr);

                DB::table('products_photos')
                    ->where('id', $item->id)
                    ->update(['image' => $result]);

                Image::make(public_path('/storage/product/' . $result))
                    ->resize(55, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/55/' . $result));

                Image::make(public_path('/storage/product/' . $result))
                    ->resize(350, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/350/' . $result));

                Image::make(public_path('/storage/product/' . $result))
                    ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/500/' . $result));

                Image::make(public_path('/storage/product/' . $result))
                    ->save(public_path('storage/products/' . $result));
            } else {
                Image::make(public_path('/storage/product/' . $item->image))
                    ->resize(55, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/55/' . $item->image));

                Image::make(public_path('/storage/product/' . $item->image))
                    ->resize(350, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/350/' . $item->image));

                Image::make(public_path('/storage/product/' . $item->image))
                    ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/products/500/' . $item->image));

                Image::make(public_path('/storage/product/' . $item->image))
                    ->save(public_path('storage/products/' . $item->image));
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        //
    }
}
