<?php

use App\Models\Bookkeeping\Costs\Costs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->foreignId('cost_category_id')
                ->nullable()
                ->references('id')
                ->on('cost_categories')
                ->onDelete('set null');

        });

        $result = Costs::select('id', 'name', 'cost_category_id')->get();

        $costCategory = new \App\Models\Bookkeeping\Costs\CostCategory();
        $costCategory->title = 'Facebook';
        $costCategory->slug = 'facebook';
        $costCategory->save();

        $costCategoriesFacebook = DB::table('cost_categories')
            ->where('slug', 'facebook')
            ->select('id', 'title', 'slug')
            ->first();

        foreach ($result as $item) {
            if ($item->name == 'Таргет') {
                $item->cost_category_id = $costCategoriesFacebook->id;
                $item->update();
            }
        }

        Schema::table('costs', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign(['cost_category_id']);
            $table->dropColumn('cost_category_id');
        });
    }
}
