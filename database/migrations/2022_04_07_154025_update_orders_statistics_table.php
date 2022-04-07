<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_statistics', function (Blueprint $table) {
            $table->integer('canceled_orders_rate')->nullable();
            $table->integer('received_parcel_ratio')->nullable();
            $table->integer('returned_orders_ratio')->nullable();
        });

        Schema::table('profits', function (Blueprint $table) {
            $table->renameColumn('marginality', 'average_marginality');
            $table->dropColumn('profit_without_sale_of_air');
            $table->integer('additional_sales_sum')->nullable();
            $table->integer('prepayment_sum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
