<?php

use App\Models\Bookkeeping\OrdersStatistic;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDataInOrdersStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orders = Orders::orderBy('created_at', 'asc')
            ->get()->groupBy(function ($events) {
                return Carbon::parse($events->created_at)->format('Y-m-d');
            });
        foreach ($orders as $key => $value) {
            if (!OrdersStatistic::whereDate('date', $key)->first()) {
                OrdersStatistic::create(['date' => $key]);
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
        Schema::dropIfExists('data_in_orders_statistics');
    }
}
