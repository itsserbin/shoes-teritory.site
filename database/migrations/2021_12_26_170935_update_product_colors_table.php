<?php

use App\Models\Products;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateProductColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_color', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('color_id');
        });

        $result_products = DB::table('products_colors')
            ->select('product_id', 'color_id')
            ->get();

        foreach ($result_products as $item) {
            $product = Products::where('id', $item->product_id)->with('colors')->first();
            $product?->colors()->attach($item->color_id);
        }

        Schema::drop('products_colors');
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
