<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('resale')->default(0);
            $table->integer('discount')->nullable();
            $table->integer('total_price');

        });

        $result = \App\Models\OrderItems::all();
        foreach ($result as $item) {
            if ($item->sale_price) {
                $item->total_price = $item->sale_price * $item->count;
                $item->update();
            }
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
