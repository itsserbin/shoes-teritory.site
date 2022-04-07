<?php

use App\Models\Bookkeeping\MarketingStatistic;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('average_application_price')->nullable();
            $table->integer('average_approve_application_price')->nullable();
            $table->integer('average_done_application_price')->nullable();
            $table->integer('average_check')->nullable();
            $table->integer('average_marginality')->nullable();
            $table->integer('average_items')->nullable();
            $table->timestamps();
        });

        $orders = Orders::orderBy('created_at', 'asc')
            ->get()->groupBy(function ($events) {
                return Carbon::parse($events->created_at)->format('Y-m-d');
            });
        foreach ($orders as $key => $value) {
            if (!MarketingStatistic::whereDate('date', $key)->first()) {
                MarketingStatistic::create(['date' => $key]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_statistics');
    }
}
