<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('sub_status')->nullable();
            $table->string('purchased_goods')->nullable();
            $table->dropColumn('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('email');
            $table->dropColumn('sub_status');
            $table->dropColumn('purchased_goods');
            $table->string('city')->nullable();
        });
    }
}
