<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePreviewProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $result_products = DB::table('products')
            ->select('id', 'preview')
            ->get();


        foreach ($result_products as $item) {

            $str = ltrim($item->preview, '/');

            DB::table('products')->where('id', $item->id)->update(['preview' => $str]);
        }
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
