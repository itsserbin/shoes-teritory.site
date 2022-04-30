<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('refunds_sum')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('clear_profit')->nullable();
            $table->integer('turnover')->nullable();
            $table->integer('marginality')->nullable();
            $table->integer('average_marginality')->nullable();
            $table->integer('sale_of_air_sum')->nullable();
            $table->integer('additional_sales_sum')->nullable();
            $table->integer('additional_sales_marginality_sum')->nullable();
            $table->integer('prepayment_sum')->nullable();
            $table->integer('debt_supplier')->nullable();
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
        Schema::dropIfExists('profits');
    }
}
