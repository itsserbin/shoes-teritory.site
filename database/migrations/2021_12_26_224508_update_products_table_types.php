<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = DB::table('products')
            ->select('id', 'viewed')
            ->where('viewed', '!=', null)
            ->get();

        foreach ($products as $product) {
            DB::table('products')->where('id', $product->id)->update(['viewed' => null]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->integer('trade_price')->nullable()->change();
            $table->integer('total_sales')->nullable()->change();
            $table->integer('viewed')->nullable()->change();

            $table->integer('provider_id')
                ->nullable()
                ->change();

        });
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
