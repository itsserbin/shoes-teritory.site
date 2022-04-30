<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('catalog')->nullable();
            $table->string('availability')->nullable();
            $table->boolean('refunds')->default(0);
            $table->integer('refunds_sum')->nullable();
            $table->boolean('prepayment')->default(0);
            $table->integer('prepayment_sum')->nullable();
            $table->string('time_of_dispatch')->nullable();
            $table->string('comment')->nullable();
            $table->string('contacts')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
