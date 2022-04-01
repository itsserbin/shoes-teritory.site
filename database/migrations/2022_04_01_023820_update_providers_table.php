<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function ($table) {
            $table->renameColumn('refunds', 'refunds_sum');
            $table->string('availability')->nullable()->change();
            $table->integer('prepayment_sum')->nullable();
            $table->boolean('prepayment')->default(0)->change();
        });

        Schema::table('providers', function ($table) {
            $table->boolean('refunds')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
