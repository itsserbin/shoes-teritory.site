<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDataInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orderItemsRepository = new \App\Repositories\OrderItemsRepository();

        $orders = \App\Models\Orders::orderBy('id', 'desc')->get();

        foreach ($orders as $order) {

            $items = $orderItemsRepository->getByOrderId($order->id);

            if ($order->sale_of_air) {
                $order->clear_total_price = $items->sum('profit') + $order->sale_of_air_price;
            } else {
                $order->clear_total_price = $items->sum('profit');
            }

            $order->update();
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('orders', function (Blueprint $table) {

//        });
    }
}
