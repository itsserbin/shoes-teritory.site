<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('status');
            $table->string('city')->nullable();
            $table->string('waybill')->nullable();
            $table->string('postal_office')->nullable();

            $table->text('comment')->nullable();

            $table->foreignId('client_id')
                ->nullable()
                ->references('id')
                ->on('clients')
                ->onDelete('set null');

            $table->integer('total_count');
            $table->integer('total_price');
            $table->boolean('sms_waybill_status')->default(0);
            $table->string('promo_code')->nullable();

            $table->string('manager')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
