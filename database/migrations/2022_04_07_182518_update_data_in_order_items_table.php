<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDataInOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $items = \App\Models\OrderItems::all();
        foreach ($items as $item) {
            if ($item->resale) {
                $item->total_price = $item->sale_price * $item->count - $item->discount;
            } else {
                $item->total_price = $item->sale_price * $item->count;
            }
            $item->clear_total_price = $item->total_price - $item->trade_price;
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
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}
