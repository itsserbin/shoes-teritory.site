<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('number_of_purchases')->nullable();
            $table->string('whole_check')->nullable();
            $table->string('average_check')->nullable();
            $table->string('status');
            $table->string('modified_by')->nullable();
            $table->text('comment')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('sub_status')->nullable();
            $table->string('purchased_goods')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
