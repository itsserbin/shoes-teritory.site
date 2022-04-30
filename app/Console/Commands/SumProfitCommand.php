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

        if (!$profit_now) {
            $profit = $this->profitsRepository->createNewModel();
            $profit->date = $date_now;
            $profit->save();
        }

        foreach ($profit_old as $item) {
            $created_at = $item->date->toDateString();
            $item->turnover = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($created_at);
            $item->cost = $this->costsRepository->sumCostsByDate($created_at);
            $item->marginality = $this->ordersRepository->sumDoneOrdersClearTotalPriceByDate($created_at);
            $item->refunds_sum = $this->orderItemsRepository->sumRefundsByDate($created_at);
            $item->clear_profit = $item->marginality - $item->cost - $item->refunds_sum;
            $item->prepayment_sum = $this->ordersRepository->sumPrepaymentByDate($created_at);
            $item->debt_supplier = $item->marginality - $item->prepayment_sum - $item->refunds_sum;
            $item->sale_of_air_sum = $this->ordersRepository->sumPriceSalesOfAirMarginality($created_at);
            $item->average_marginality = $this->ordersRepository->averageMarginalityByDate($created_at);
            $item->additional_sales_sum = $this->orderItemsRepository->sumAdditionalSalesByDate($created_at);
            $item->additional_sales_marginality_sum = $this->orderItemsRepository->sumMarginalityAdditionalSalesByDate($created_at);
            $item->update();
        }
    }
}
