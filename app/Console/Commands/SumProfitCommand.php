<?php

namespace App\Console\Commands;

use App\Models\Bookkeeping\Costs;
use App\Models\Bookkeeping\Profit;
use App\Models\Enum\OrderStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SumProfitCommand
{
    public function __construct()
    {
        $date_now = Carbon::now()->format('Y-m-d');

        $profit_now = Profit::whereDate('date', $date_now)->get();

        $profit_old = Profit::all();

        foreach ($profit_old as $item) {
            $created_at = $item->date->format('Y-m-d');

            $item->profit = $ProfitProfit = DB::table('orders')
                ->whereDate('orders.created_at', $created_at)
                ->where('status', OrderStatus::STATUS_DONE)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select(['orders.id',
                    'order_items.order_id',
                    'order_items.profit',])
                ->sum('order_items.profit');

            $item->cost = $ProfitCost = Costs::whereDate('date', $created_at)
                ->select('total')
                ->sum('total');

            $item->marginality = $ProfitProfit - $ProfitCost;

            $item->turnover = $ProfitProfit + $ProfitCost;

            $item->update();
        }

        if (count($profit_now)) {
            foreach ($profit_now as $item) {

                $item->profit = $ProfitProfit =
                    DB::table('orders')
                        ->whereDate('orders.created_at', $date_now)
                        ->where('status', OrderStatus::STATUS_DONE)
                        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                        ->select([
                            'orders.id',
                            'order_items.order_id',
                            'order_items.profit',
                        ])
                        ->sum('order_items.profit');

                $item->cost = $ProfitCost = Costs::whereDate('date', $date_now)
                    ->select('total')
                    ->sum('total');

                $item->marginality = $ProfitProfit - $ProfitCost;
                $item->turnover = $ProfitProfit + $ProfitCost;
                $item->update();
            }
        } else {
            $profit = new Profit();
            $profit->date = $date_now;
            $profit->cost = $ProfitCost = Costs::whereDate('date', $date_now)
                ->select('total')
                ->sum('total');

            $profit->profit = $ProfitProfit = DB::table('orders')
                ->whereDate('orders.created_at', $date_now)
                ->where('status', OrderStatus::STATUS_DONE)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select([
                    'orders.id',
                    'order_items.order_id',
                    'order_items.profit',
                ])
                ->sum('order_items.profit');

            $profit->marginality = $ProfitProfit - $ProfitCost;
            $profit->turnover = $ProfitProfit + $ProfitCost;
            $profit->save();;
        }
    }
}
