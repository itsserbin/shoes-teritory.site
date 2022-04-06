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
            $table->integer('clear_total_price');
        });

        $items = \App\Models\OrderItems::select('id', 'profit', 'count', 'clear_total_price')->get();
        foreach ($items as $item) {
            $item->clear_total_price = $item->profit * $item->count;
            $item->update();
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
