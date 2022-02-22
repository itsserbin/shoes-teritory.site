<?php

namespace App\Console\Commands;

use App\Models\Bookkeeping\Costs\Costs;
use App\Models\Bookkeeping\OrdersDay;
use App\Models\Bookkeeping\Profit;
use App\Models\Enum\OrderStatus;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_statistics:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_now = Carbon::now()->format('Y-m-d');

        $orders_old = OrdersDay::all();
        $orders_days = OrdersDay::whereDate('date', $date_now)->first();

        $OrdersCountNow = Orders::whereDate('created_at', $date_now)
            ->count();

        $DoneOrdersCountNow = Orders::whereDate('created_at', $date_now)
            ->where('status', OrderStatus::STATUS_DONE)
            ->count();

        $CancelOrdersCountNow = Orders::whereDate('created_at', $date_now)
            ->where('status', OrderStatus::STATUS_CANCELED)
            ->count();

        $SumCostsNow = Costs::whereDate('date', $date_now)
            ->where('cost_category_id', 1)
            ->select('total')
            ->sum('total');

        $SumDayProfitNow = Profit::whereDate('created_at', $date_now)
            ->select('profit')
            ->sum('profit');

        $SumDayMarginalityNow = Profit::whereDate('date', $date_now)
            ->select('marginality')
            ->sum('marginality');

        $SumDayCostsNow = Profit::whereDate('created_at', $date_now)
            ->select('cost')
            ->sum('cost');

        $ReturnOrdersCountNow = Orders::whereDate('created_at', $date_now)
            ->where('status', OrderStatus::STATUS_RETURN)
            ->count();

        if ($orders_days == null) {
            $orders_days = new OrdersDay();
            $orders_days->date = $date_now;

            $orders_days->advertising = Costs::whereDate('date', $date_now)
                ->where('cost_category_id', 1)
                ->select('total')
                ->sum('total');

            $orders_days->applications = Orders::whereDate('created_at', $date_now)
                ->count();

            if ($orders_days->applications > 0) {
                $orders_days->application_price = $orders_days->advertising / $orders_days->applications;
            } else {
                $orders_days->application_price = '-';
            }

            $orders_days->in_process = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_PROCESSED)
                ->count();

            $orders_days->transferred_to_supplier = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER)
                ->count();

            $orders_days->unprocessed = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_NEW)
                ->count();

            $orders_days->at_the_post_office = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_AT_THE_POST_OFFICE)
                ->count();

            $orders_days->completed_applications = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_DONE)
                ->count();

            $orders_days->refunds = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_RETURN)
                ->count();

            $orders_days->cancel = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_CANCELED)
                ->count();

            $orders_days->awaiting_dispatch = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_AWAITING_DISPATCH)
                ->count();

            $orders_days->awaiting_prepayment = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_AWAITING_PREPAYMENT)
                ->count();

            $orders_days->on_the_road = Orders::whereDate('created_at', $date_now)
                ->where('status', OrderStatus::STATUS_ON_THE_ROAD)
                ->count();

            if ($OrdersCountNow !== 0) {
                $orders_days->canceled_orders_rate = $CancelOrdersCountNow / $OrdersCountNow;
                $orders_days->returned_orders_ratio = $ReturnOrdersCountNow / $OrdersCountNow;
                $orders_days->received_parcel_ratio = $DoneOrdersCountNow / $OrdersCountNow;
            }

            $orders_days->manager_salary = ($DoneOrdersCountNow + $ReturnOrdersCountNow) * 15;

            $orders_days->costs = $SumCostsNow + $orders_days->manager_salary + (100 * $ReturnOrdersCountNow);

            $orders_days->profit = $SumDayProfitNow;

            $orders_days->net_profit = $orders_days->profit - $orders_days->costs;

            if ($DoneOrdersCountNow !== 0) {
                $orders_days->client_cost = $orders_days->net_profit / $DoneOrdersCountNow;
            }

            if ($SumDayCostsNow !== 0) {
                $orders_days->marginality = $orders_days->profit / $orders_days->costs;
            }

            $orders_days->investor_profit = $SumCostsNow * 0.05;

            $orders_days->save();
        } else {
            foreach ($orders_old as $item) {
                $date = $item->date->format('Y-m-d');

                $OrdersCount = Orders::whereDate('created_at', $date)
                    ->count();

                $DoneOrdersCount = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_DONE)
                    ->count();

                $CancelOrdersCount = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_CANCELED)
                    ->count();

                $SumCosts = Costs::whereDate('date', $date)
                    ->where('cost_category_id', 1)
                    ->select('total')
                    ->sum('total');

                $SumDayProfit = Profit::whereDate('created_at', $date)
                    ->select('profit')
                    ->sum('profit');

                $SumDayCosts = Profit::whereDate('created_at', $date)
                    ->select('cost')
                    ->sum('cost');

                $ReturnOrdersCount = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_RETURN)
                    ->count();

                $item->advertising = Costs::whereDate('date', $date)
                    ->where('cost_category_id', 1)
                    ->select('total')
                    ->sum('total');

                $item->applications = Orders::whereDate('created_at', $date)
                    ->count();

                if ($item->applications > 0) {
                    $item->application_price = $item->advertising / $item->applications;
                } else {
                    $item->application_price = '-';
                }

                $item->in_process = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_PROCESSED)
                    ->count();

                $item->transferred_to_supplier = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER)
                    ->count();

                $item->at_the_post_office = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_AT_THE_POST_OFFICE)
                    ->count();

                $item->completed_applications = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_DONE)
                    ->count();

                $item->unprocessed = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_NEW)
                    ->count();

                $item->refunds = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_RETURN)
                    ->count();

                $item->cancel = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_CANCELED)
                    ->count();

                $item->awaiting_dispatch = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_AWAITING_DISPATCH)
                    ->count();

                $item->awaiting_prepayment = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_AWAITING_PREPAYMENT)
                    ->count();

                $item->on_the_road = Orders::whereDate('created_at', $date)
                    ->where('status', OrderStatus::STATUS_ON_THE_ROAD)
                    ->count();

                if ($OrdersCount !== 0) {
                    $item->canceled_orders_rate = $CancelOrdersCount / $OrdersCount;
                    $item->returned_orders_ratio = $ReturnOrdersCount / $OrdersCount;
                    $item->received_parcel_ratio = $DoneOrdersCount / $OrdersCount;
                }

                $item->manager_salary = ($DoneOrdersCount + $ReturnOrdersCount) * 15;

                $item->profit = $SumDayProfit;

                $item->costs = $SumCosts + $item->manager_salary + (100 * $ReturnOrdersCount);

                $item->net_profit = ($item->profit) - ($item->costs);

                if ($DoneOrdersCount !== 0) {
                    $item->client_cost = $item->net_profit / $DoneOrdersCount;
                }

                if ($SumDayCosts !== 0) {
                    $item->marginality = $item->profit / $item->costs;
                }

                $item->investor_profit = $SumCosts * 0.05;

                $item->update();
            }
        }
    }
}
