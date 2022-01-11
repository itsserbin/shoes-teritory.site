<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;

class UpdatePreview2 extends Migration
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

            $arr = explode('/', $item->preview);
            $result = array_pop($arr);

            Image::make(public_path($item->preview))
                ->resize(55, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/products/55/' . $result));

            Image::make(public_path($item->preview))
                ->resize(350, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/products/350/' . $result));

            Image::make(public_path($item->preview))
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/products/500/' . $result));


            DB::table('products')->where('id', $item->id)->update(['preview' => $result]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
