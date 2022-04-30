<?php

namespace App\Console\Commands;

use App\Repositories\Bookkeeping\CostsRepository;
use App\Repositories\Bookkeeping\MarketingStatisticRepository;
use App\Repositories\Bookkeeping\OrdersStatisticsRepository;
use App\Repositories\Bookkeeping\ProfitsRepository;
use App\Repositories\OrdersRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarketingStatisticConmmand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketing_statistic:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $marketingStatisticRepository;
    protected $ordersStatisticsRepository;
    protected $costsRepository;
    protected $ordersRepository;
    protected $profitsRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->marketingStatisticRepository = app(MarketingStatisticRepository::class);
        $this->ordersStatisticsRepository = app(OrdersStatisticsRepository::class);
        $this->costsRepository = app(CostsRepository::class);
        $this->ordersRepository = app(OrdersRepository::class);
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

        $statisticNow = $this->marketingStatisticRepository->getRowByDate($date_now);
        $statisticOld = $this->marketingStatisticRepository->getAll();

        if (!$statisticNow) {
            $profit = $this->marketingStatisticRepository->createNewModel();
            $profit->date = $date_now;
            $profit->save();
        }

        foreach ($statisticOld as $item) {
            $ordersStatisticModel = $this->ordersStatisticsRepository->getRowByDate($item->date);
            $costsSum = $this->costsRepository->sumCostsByDate($item->date);
            if ($ordersStatisticModel) {
                if ($ordersStatisticModel->applications) {
                    $item->average_application_price = $costsSum / $ordersStatisticModel->applications;
                } else {
                    $item->average_application_price = 0;
                }
                if ($ordersStatisticModel->completed + $ordersStatisticModel->refunds + $ordersStatisticModel->transferred_to_supplier + $ordersStatisticModel->awaiting_dispatch + $ordersStatisticModel->on_the_road + $ordersStatisticModel->at_the_post_office) {
                    $item->average_approve_application_price = $costsSum / ($ordersStatisticModel->completed + $ordersStatisticModel->refunds + $ordersStatisticModel->transferred_to_supplier + $ordersStatisticModel->awaiting_dispatch + $ordersStatisticModel->on_the_road + $ordersStatisticModel->at_the_post_office);
                } else {
                    $item->average_approve_application_price = 0;
                }
                if ($ordersStatisticModel->completed) {
                    $item->average_done_application_price = $costsSum / $ordersStatisticModel->completed;
                } else {
                    $item->average_done_application_price = 0;
                }
            }
            $item->average_check = $this->ordersRepository->averageCheckOfCompletedOrdersByDate($item->date);
            $item->average_items = $this->ordersRepository->averageCountItemsCompletedOrdersByDate($item->date);
            $item->average_marginality = $this->profitsRepository->averageMarginalityByDate($item->date);
            $item->update();
        }
    }
}
