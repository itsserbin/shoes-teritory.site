<?php

namespace App\Console\Commands;

use App\Models\Enum\OrderStatus;
use App\Repositories\Bookkeeping\OrdersStatisticsRepository;
use App\Repositories\OrdersRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrdersStatisticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orderStatistics:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $ordersRepository;
    private $ordersStatisticsRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(OrdersRepository::class);
        $this->ordersStatisticsRepository = app(OrdersStatisticsRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dateNow = Carbon::now()->toDateString();

        $statisticsNow = $this->ordersStatisticsRepository->getRowByDate($dateNow);

        if (!$statisticsNow) {
            $model = $this->ordersStatisticsRepository->createNewModel();
            $model->date = $dateNow;
            $model->applications = $this->ordersRepository->countOrdersByStatus(null, $dateNow);
            $model->unprocessed = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_NEW, $dateNow);
            $model->completed = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_DONE, $dateNow);
            $model->refunds = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_RETURN, $dateNow);
            $model->cancel = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_CANCELED, $dateNow);
            $model->at_the_post_office = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AT_THE_POST_OFFICE, $dateNow);
            $model->in_process = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_PROCESSED, $dateNow);
            $model->transferred_to_supplier = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER, $dateNow);
            $model->awaiting_dispatch = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AWAITING_DISPATCH, $dateNow);
            $model->awaiting_prepayment = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AWAITING_PREPAYMENT, $dateNow);
            $model->on_the_road = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_ON_THE_ROAD, $dateNow);
            if ($model->applications) {
                $model->canceled_orders_rate = $model->cancel / $model->applications;
                $model->returned_orders_ratio = $model->refunds / $model->applications;
                $model->received_parcel_ratio = $model->completed / $model->applications;
            }
            $model->save();
        }

        $statisticsAll = $this->ordersStatisticsRepository->getAll();

        foreach ($statisticsAll as $item) {
            $item->applications = $this->ordersRepository->countOrdersByStatus(null, $item->date);
            $item->unprocessed = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_NEW, $item->date);
            $item->completed = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_DONE, $item->date);
            $item->refunds = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_RETURN, $item->date);
            $item->cancel = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_CANCELED, $item->date);
            $item->at_the_post_office = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AT_THE_POST_OFFICE, $item->date);
            $item->in_process = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_PROCESSED, $item->date);
            $item->transferred_to_supplier = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER, $item->date);
            $item->awaiting_dispatch = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AWAITING_DISPATCH, $item->date);
            $item->awaiting_prepayment = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_AWAITING_PREPAYMENT, $item->date);
            $item->on_the_road = $this->ordersRepository->countOrdersByStatus(OrderStatus::STATUS_ON_THE_ROAD, $item->date);
            if ($item->applications) {
                $item->canceled_orders_rate = ($item->cancel / $item->applications) * 100;
                $item->returned_orders_ratio = ($item->refunds / $item->applications) * 100;
                $item->received_parcel_ratio = ($item->completed / $item->applications) * 100;
            }
            $item->update();
        }
    }
}
