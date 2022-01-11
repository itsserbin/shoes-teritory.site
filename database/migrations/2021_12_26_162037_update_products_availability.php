<?php

use App\Models\Enum\ProductAvailability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateProductsAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $result_products = DB::table('products')
            ->select('id', 'status')
            ->get();


        foreach ($result_products as $item) {
            if ($item->status = 'В наличии') {
                $value = ProductAvailability::IN_STOCK;
            } elseif ($item->status = 'Заканчивается') {
                $value = ProductAvailability::ENDS;
            } else {
                $value = ProductAvailability::OUT_OF_STOCK;
            }

            DB::table('products')->where('id', $item->id)->update(['status' => $value]);
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
