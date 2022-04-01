<?php

namespace App\Console\Commands;

use App\Repositories\Bookkeeping\CostsRepository;
use App\Repositories\Bookkeeping\ProfitsRepository;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SumProfitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profit:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $ordersRepository;
    private $orderItemsRepository;
    private $costsRepository;
    private $profitsRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(OrdersRepository::class);
        $this->orderItemsRepository = app(OrderItemsRepository::class);
        $this->costsRepository = app(CostsRepository::class);
        $this->profitsRepository = app(ProfitsRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_now = Carbon::now()->toDateString();

        $profit_now = $this->profitsRepository->getRowByDate($date_now);
        $profit_old = $this->profitsRepository->getAll();

        foreach ($profit_old as $item) {
            $created_at = $item->date->toDateString();
            $item->turnover = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($created_at);
            $item->sale_of_air_sum = $this->ordersRepository->sumPriceSalesOfAirMarginality($created_at);
            $item->profit = $this->orderItemsRepository->sumProfitByDate($created_at) + $item->sale_of_air_sum;
            $item->profit_without_sale_of_air = $this->orderItemsRepository->sumProfitByDate($created_at);
            $item->cost = $this->costsRepository->sumCostsByDate($created_at);
            $item->refunds_sum = $this->orderItemsRepository->sumRefundsByDate($created_at);
            $item->clear_profit = $item->profit - $item->cost - $item->refunds_sum;
            $item->update();
        }

        if ($profit_now) {
            $profit_now->turnover = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($date_now);
            $profit_now->sale_of_air_sum = $this->ordersRepository->sumPriceSalesOfAirMarginality($profit_now);
            $profit_now->profit = $this->orderItemsRepository->sumProfitByDate($date_now) + $profit_now->sale_of_air_sum;
            $profit_now->profit_without_sale_of_air = $this->orderItemsRepository->sumProfitByDate($date_now);
            $profit_now->cost = $this->costsRepository->sumCostsByDate($date_now);
            $profit_now->refunds_sum = $this->orderItemsRepository->sumRefundsByDate($profit_now);
            $profit_now->clear_profit = $profit_now->profit - $profit_now->cost - $profit_now->refunds_sum;
            $profit_now->update();
        } else {
            $profit = $this->profitsRepository->createNewModel();
            $profit->date = $date_now;
            $profit->turnover = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($date_now);
            $profit->sale_of_air_sum = $this->ordersRepository->sumPriceSalesOfAirMarginality($date_now);
            $profit->profit = $this->orderItemsRepository->sumProfitByDate($date_now) + $profit->sale_of_air_sum;
            $profit->profit_without_sale_of_air = $this->orderItemsRepository->sumProfitByDate($date_now);
            $profit->cost = $this->costsRepository->sumCostsByDate($date_now);
            $profit->refunds_sum = $this->orderItemsRepository->sumRefundsByDate($date_now);
            $profit->clear_profit = $profit->profit - $profit->cost - $profit->refunds_sum;
            $profit->save();;
        }
    }
}
