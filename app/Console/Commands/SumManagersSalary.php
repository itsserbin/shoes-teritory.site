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
        $managerSalaryNow = $this->managersSalaryRepository->getRowByDate($dateNow);
        $managerSalaryAll = $this->managersSalaryRepository->getAll();

        if ($managerSalaryNow) {
            foreach ($managers as $manager) {
                if ($managerSalaryNow->manager_id == $manager->id) {
                    $managerSalaryNow->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryNow->date, $manager->id);

                    $managerSalaryNow->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->returned_applications = $this->ordersRepository->sumReturnedApplications($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->total_applications = $this->ordersRepository->sumApprovalApplications($managerSalaryNow->date, $manager->id);

                    $managerSalaryNow->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($managerSalaryNow->date, $manager->id);
                    $managerSalaryNow->total_sale_of_air = $managerSalaryNow->price_sale_of_air * 0.2;

                    $managerSalaryNow->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date, $manager->id);

                    $pr = $this->ordersRepository->countWithParcelReminder($managerSalaryNow->date, $manager->id);
                    $wpr = $this->ordersRepository->countWithoutParcelReminder($managerSalaryNow->date, $manager->id);

                    if ($managerSalaryNow->count_applications <= 49) {
                        $managerSalaryNow->sum_price_applications = $pr * 16;
                        $managerSalaryNow->sum_price_applications += $wpr * 13;
                        $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date, $manager->id) * 0.2;
                    } elseif ($managerSalaryNow->count_applications > 50) {
                        $managerSalaryNow->sum_price_applications = $pr * 15;
                        $managerSalaryNow->sum_price_applications += $wpr * 12;
                        $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date, $manager->id) * 0.18;
                    } else {
                        $managerSalaryNow->sum_price_applications = $pr * 14;
                        $managerSalaryNow->sum_price_applications += $wpr * 11;
                        $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date, $manager->id) * 0.15;
                    }
                    $managerSalaryNow->total_price = $managerSalaryNow->sum_price_applications + $managerSalaryNow->sum_price_additional_sales + $managerSalaryNow->total_sale_of_air;
                    $managerSalaryNow->update();
                }
            }
            if (!$managerSalaryNow->manager_id) {
                $managerSalaryNow->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryNow->date);
                $managerSalaryNow->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryNow->date);

                $managerSalaryNow->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($managerSalaryNow->date);
                $managerSalaryNow->returned_applications = $this->ordersRepository->sumReturnedApplications($managerSalaryNow->date);
                $managerSalaryNow->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryNow->date);
                $managerSalaryNow->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryNow->date);
                $managerSalaryNow->total_applications = $this->ordersRepository->sumApprovalApplications($managerSalaryNow->date);

                $managerSalaryNow->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($managerSalaryNow->date);
                $managerSalaryNow->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($managerSalaryNow->date);
                $managerSalaryNow->total_sale_of_air = $managerSalaryNow->price_sale_of_air * 0.2;

                $managerSalaryNow->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date);

                $pr = $this->ordersRepository->countWithParcelReminder($managerSalaryNow->date);
                $wpr = $this->ordersRepository->countWithoutParcelReminder($managerSalaryNow->date);

                if ($managerSalaryNow->count_applications <= 49) {
                    $managerSalaryNow->sum_price_applications = $pr * 16;
                    $managerSalaryNow->sum_price_applications += $wpr * 13;
                    $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date) * 0.2;
                } elseif ($managerSalaryNow->count_applications > 50) {
                    $managerSalaryNow->sum_price_applications = $pr * 15;
                    $managerSalaryNow->sum_price_applications += $wpr * 12;
                    $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date) * 0.18;
                } else {
                    $managerSalaryNow->sum_price_applications = $pr * 14;
                    $managerSalaryNow->sum_price_applications += $wpr * 11;
                    $managerSalaryNow->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryNow->date) * 0.15;
                }
                $managerSalaryNow->total_price = $managerSalaryNow->sum_price_applications + $managerSalaryNow->sum_price_additional_sales + $managerSalaryNow->total_sale_of_air;
                $managerSalaryNow->update();
            }
        } else {
            $item = $this->managersSalaryRepository->createNewModel();
            $item->date = $dateNow;
            $item->count_applications = $this->ordersRepository->sumOrdersCount($dateNow);
            $item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($dateNow);

            $item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($dateNow);
            $item->returned_applications = $this->ordersRepository->sumReturnedApplications($dateNow);
            $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow);
            $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow);
            $item->total_applications = $this->ordersRepository->sumApprovalApplications($dateNow);

            $item->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($dateNow);
            $item->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($dateNow);
            $item->total_sale_of_air = $item->price_sale_of_air * 0.2;

            $item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow);

            $pr = $this->ordersRepository->countWithParcelReminder($dateNow);
            $wpr = $this->ordersRepository->countWithoutParcelReminder($dateNow);

            if ($item->count_applications <= 49) {
                $item->sum_price_applications = $pr * 16;
                $item->sum_price_applications += $wpr * 13;
                $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow) * 0.2;
            } elseif ($item->count_applications > 50) {
                $item->sum_price_applications = $pr * 15;
                $item->sum_price_applications += $wpr * 12;
                $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow) * 0.18;
            } else {
                $item->sum_price_applications = $pr * 14;
                $item->sum_price_applications += $wpr * 11;
                $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow) * 0.15;
            }

            $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales + $item->total_sale_of_air;
            $item->save();

            foreach ($managers as $manager) {
                $manager_item = $this->managersSalaryRepository->createNewModel();
                $manager_item->date = $dateNow;
                $manager_item->manager_id = $manager->id;
                $manager_item->count_applications = $this->ordersRepository->sumOrdersCount($dateNow, $manager->id);
                $manager_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($dateNow, $manager->id);

                $manager_item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($dateNow, $manager->id);
                $manager_item->returned_applications = $this->ordersRepository->sumReturnedApplications($dateNow, $manager->id);
                $manager_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow, $manager->id);
                $manager_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow, $manager->id);
                $manager_item->total_applications = $this->ordersRepository->sumApprovalApplications($dateNow, $manager->id);

                $manager_item->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($dateNow, $manager->id);
                $manager_item->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($dateNow, $manager->id);
                $manager_item->total_sale_of_air = $manager_item->price_sale_of_air * 0.2;

                $manager_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id);

                $pr = $this->ordersRepository->countWithParcelReminder($dateNow, $manager->id);
                $wpr = $this->ordersRepository->countWithoutParcelReminder($dateNow, $manager->id);

                if ($manager_item->count_applications <= 49) {
                    $manager_item->sum_price_applications = $pr * 16;
                    $manager_item->sum_price_applications += $wpr * 13;
                    $manager_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id) * 0.2;
                } elseif ($manager_item->count_applications > 50) {
                    $manager_item->sum_price_applications = $pr * 15;
                    $manager_item->sum_price_applications += $wpr * 12;
                    $manager_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id) * 0.18;
                } else {
                    $manager_item->sum_price_applications = $pr * 14;
                    $manager_item->sum_price_applications += $wpr * 11;
                    $manager_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow, $manager->id) * 0.15;
                }

                $manager_item->total_price = $manager_item->sum_price_applications + $manager_item->sum_price_additional_sales + $manager_item->total_sale_of_air;
                $manager_item->save();
            }
        }

        foreach ($managerSalaryAll as $managerSalaryAll_item) {
            foreach ($managers as $manager) {
                if ($managerSalaryAll_item->manager_id == $manager->id) {
                    $managerSalaryAll_item->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryAll_item->date, $manager->id);

                    $managerSalaryAll_item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->returned_applications = $this->ordersRepository->sumReturnedApplications($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->total_applications = $this->ordersRepository->sumApprovalApplications($managerSalaryAll_item->date, $manager->id);

                    $managerSalaryAll_item->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($managerSalaryAll_item->date, $manager->id);
                    $managerSalaryAll_item->total_sale_of_air = $managerSalaryAll_item->price_sale_of_air * 0.2;

                    $managerSalaryAll_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id);

                    $pr = $this->ordersRepository->countWithParcelReminder($managerSalaryAll_item->date, $manager->id);
                    $wpr = $this->ordersRepository->countWithoutParcelReminder($managerSalaryAll_item->date, $manager->id);

                    if ($managerSalaryAll_item->count_applications <= 49) {
                        $managerSalaryAll_item->sum_price_applications = $pr * 16;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 13;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id) * 0.2;
                    } elseif ($managerSalaryAll_item->count_applications > 50) {
                        $managerSalaryAll_item->sum_price_applications = $pr * 15;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 12;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id) * 0.18;
                    } else {
                        $managerSalaryAll_item->sum_price_applications = $pr * 14;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 11;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date, $manager->id) * 0.15;
                    }

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales + $managerSalaryAll_item->total_sale_of_air;
                    $managerSalaryAll_item->update();

                }
                if (!$managerSalaryAll_item->manager_id) {
                    $managerSalaryAll_item->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryAll_item->date);

                    $managerSalaryAll_item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($managerSalaryAll_item->date);
                    $managerSalaryAll_item->returned_applications = $this->ordersRepository->sumReturnedApplications($managerSalaryAll_item->date);
                    $managerSalaryAll_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->total_applications = $this->ordersRepository->sumApprovalApplications($managerSalaryAll_item->date);

                    $managerSalaryAll_item->count_sale_of_air = $this->ordersRepository->sumCountSalesOfAirMarginality($managerSalaryAll_item->date);
                    $managerSalaryAll_item->price_sale_of_air = $this->ordersRepository->sumPriceSalesOfAirMarginality($managerSalaryAll_item->date);
                    $managerSalaryAll_item->total_sale_of_air = $managerSalaryAll_item->price_sale_of_air * 0.2;

                    $managerSalaryAll_item->sum_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date);

                    $pr = $this->ordersRepository->countWithParcelReminder($managerSalaryAll_item->date);
                    $wpr = $this->ordersRepository->countWithoutParcelReminder($managerSalaryAll_item->date);

                    if ($managerSalaryAll_item->count_applications <= 49) {
                        $managerSalaryAll_item->sum_price_applications = $pr * 16;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 13;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date) * 0.2;
                    } elseif ($managerSalaryAll_item->count_applications > 50) {
                        $managerSalaryAll_item->sum_price_applications = $pr * 15;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 12;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date) * 0.18;
                    } else {
                        $managerSalaryAll_item->sum_price_applications = $pr * 14;
                        $managerSalaryAll_item->sum_price_applications += $wpr * 11;
                        $managerSalaryAll_item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($managerSalaryAll_item->date) * 0.15;
                    }

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales + $managerSalaryAll_item->total_sale_of_air;
                    $managerSalaryAll_item->update();
                }
            }
        }
    }
}
