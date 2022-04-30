<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('applications')->nullable();
            $table->integer('unprocessed')->nullable();
            $table->integer('completed')->nullable();
            $table->integer('refunds')->nullable();
            $table->integer('cancel')->nullable();
            $table->integer('at_the_post_office')->nullable();
            $table->integer('in_process')->nullable();
            $table->integer('transferred_to_supplier')->nullable();
            $table->integer('awaiting_dispatch')->nullable();
            $table->integer('awaiting_prepayment')->nullable();
            $table->integer('on_the_road')->nullable();

            $table->integer('canceled_orders_rate')->nullable();
            $table->integer('received_parcel_ratio')->nullable();
            $table->integer('returned_orders_ratio')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_statistics');
    }
}
