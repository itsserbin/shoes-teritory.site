<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profits', function ($table) {
            $table->renameColumn('marginality', 'clear_profit');

            $table->integer('refunds_sum')->nullable();
            $table->integer('cost')->nullable()->change();
            $table->integer('profit')->nullable()->change();
            $table->integer('clear_profit')->nullable()->change();
            $table->integer('turnover')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
