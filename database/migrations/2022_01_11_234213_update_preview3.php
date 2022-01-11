<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;

class UpdatePreview3 extends Migration
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
            Image::make(public_path('storage/product/' . $item->preview))
                ->save(public_path('storage/products/' . $item->preview));
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
