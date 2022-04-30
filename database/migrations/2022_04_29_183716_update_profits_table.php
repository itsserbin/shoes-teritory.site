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
        Schema::table('profits', function (Blueprint $table) {
            $table->integer('marginality')->nullable();
            $table->integer('additional_sales_marginality_sum')->nullable();
            $table->integer('debt_supplier')->nullable();
            $table->dropColumn('profit');
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
