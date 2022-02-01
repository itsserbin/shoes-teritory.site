<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateManagersSalariesAtble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manager_salaries', function (Blueprint $table) {
            $table->integer('count_sale_of_air')->nullable();
            $table->integer('price_sale_of_air')->nullable();
            $table->integer('total_sale_of_air')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manager_salaries', function (Blueprint $table) {
            $table->dropColumn('sale_of_air');
        });
    }
}
