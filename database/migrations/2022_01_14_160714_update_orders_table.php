<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_count');
            $table->integer('total_price');
            $table->boolean('sms_waybill_status')->default(0);
            $table->string('promo_code')->nullable();
            $table->dropForeign('orders_product_id_foreign');
            $table->dropColumn('product_id');
            $table->dropColumn('trade_price');
            $table->dropColumn('sale_price');
            $table->dropColumn('product_name');
            $table->dropColumn('sizes');
            $table->dropColumn('colors');
            $table->dropColumn('profit');
            $table->dropColumn('pay');
            $table->dropColumn('name');
            $table->dropColumn('phone');
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
