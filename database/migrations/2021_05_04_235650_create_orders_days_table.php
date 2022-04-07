<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_days', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('application_price')->nullable();
            $table->string('unprocessed')->nullable();
            $table->string('advertising')->nullable();
            $table->string('applications')->nullable();
            $table->string('completed_applications')->nullable();
            $table->string('refunds')->nullable();
            $table->string('cancel')->nullable();
            $table->string('at_the_post_office')->nullable();
            $table->string('in_process')->nullable();
            $table->string('price_per_application')->nullable();
            $table->string('transferred_to_supplier')->nullable();
            $table->string('canceled_orders_rate')->nullable();
            $table->string('received_parcel_ratio')->nullable();
            $table->string('returned_orders_ratio')->nullable();
            $table->string('client_cost')->nullable();
            $table->string('profit')->nullable();
            $table->string('marginality')->nullable();
            $table->string('investor_profit')->nullable();
            $table->string('manager_salary')->nullable();
            $table->string('costs')->nullable();
            $table->string('net_profit')->nullable();
            $table->string('awaiting_dispatch')->nullable();
            $table->string('awaiting_prepayment')->nullable();
            $table->string('on_the_road')->nullable();
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
        Schema::dropIfExists('orders_days');
    }
}
