<?php

namespace App\Console\Commands;

use App\Repositories\Bookkeeping\ManagersSalaryRepository;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SumManagersSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'managers_salary:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sum managers salary';

    private $managersSalaryRepository;
    private $orderItemsRepository;
    private $ordersRepository;
    private $usersRepository;

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
        $this->managersSalaryRepository = app(ManagersSalaryRepository::class);
        $this->usersRepository = app(UsersRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dateNow = Carbon::now()->format('Y-m-d');

        $managers = $this->usersRepository->getManagersList();
        $managerSalaryNow = $this->managersSalaryRepository->getRowsByDate($dateNow);
        $managerSalaryAll = $this->managersSalaryRepository->getAll();
        if (count($managerSalaryNow)) {
            foreach ($managerSalaryNow as $item) {
                foreach ($managers as $manager) {
                    if ($item->manager_id == $manager->id) {
                        $item->count_applications = $this->ordersRepository->sumOrdersCount($item->date, $manager->id);
                        $item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($item->date, $manager->id);

                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date, $manager->id);
                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date, $manager->id);

                        $item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id);
                        if ($item->count_applications < 50) {
                            $item->sum_price_applications = $item->count_applications * 13;
                        }

                        $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.2;

                        $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
                        $item->update();

                    } else {
                        $item->count_applications = $this->ordersRepository->sumOrdersCount($item->date);
                        $item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($item->date);

                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date);
                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date);

                        $item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date);
                        if ($item->count_applications < 50) {
                            $item->sum_price_applications = $item->count_applications * 13;
                        }

                        $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date) * 0.2;

                        $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
                        $item->update();
                    }
                }
            }
        } else {
            $item = $this->managersSalaryRepository->createNewModel();
            $item->date = $dateNow;
            $item->count_applications = $this->ordersRepository->sumOrdersCount($dateNow);
            $item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($dateNow);

            $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow);
            $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow);

            $item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow);
            if ($item->count_applications < 50) {
                $item->sum_price_applications = $item->count_applications * 13;
            }

            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow) * 0.2;

            $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
            $item->save();

            foreach ($managers as $manager) {
                $manager_item = $this->managersSalaryRepository->createNewModel();
                $manager_item->date = $dateNow;
                $manager_item->manager_id = $manager->id;
                $manager_item->count_applications = $this->ordersRepository->sumOrdersCount($dateNow, $manager->id);
                $manager_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($dateNow, $manager->id);

                $manager_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow, $manager->id);
                $manager_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow, $manager->id);

                $manager_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id);
                if ($manager_item->count_applications < 50) {
                    $manager_item->sum_price_applications = $manager_item->done_applications * 13;
                }

                $manager_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id) * 0.2;

                $manager_item->total_price = $manager_item->sum_price_applications + $manager_item->sum_price_additional_sales;
                $manager_item->save();
            }
        }

        foreach ($managerSalaryAll as $managerSalaryAll_item) {
            foreach ($managers as $manager) {
                if ($managerSalaryAll_item->manager_id == $manager->id) {
                    $managerSalaryAll_item->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryAll_item->date, $manager->id);

                    $managerSalaryAll_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryAll_item->date, $manager->id);

                    $managerSalaryAll_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id);
                    if ($managerSalaryAll_item->count_applications < 50) {
                        $managerSalaryAll_item->sum_price_applications = $managerSalaryAll_item->count_applications * 13;
                    }

                    $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id) * 0.2;

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales;
                    $managerSalaryAll_item->update();

                } else {
                    $managerSalaryAll_item->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryAll_item->date);

                    $managerSalaryAll_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryAll_item->date);

                    $managerSalaryAll_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date);
                    if ($managerSalaryAll_item->count_applications < 50) {
                        $managerSalaryAll_item->sum_price_applications = $managerSalaryAll_item->count_applications * 13;
                    }

                    $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date) * 0.2;

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales;
                    $managerSalaryAll_item->update();
                }
            }
        }
    }
}
