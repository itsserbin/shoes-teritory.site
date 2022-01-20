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

                        $item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($item->date, $manager->id);
                        $item->returned_applications = $this->ordersRepository->sumReturnedApplications($item->date, $manager->id);
                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date, $manager->id);
                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date, $manager->id);
                        $item->total_applications = $item->returned_applications + $item->done_applications;

                        $pr = $this->ordersRepository->countWithParcelReminder($item->date, $manager->id);
                        $wpr = $this->ordersRepository->countWithoutParcelReminder($item->date, $manager->id);

                        if ($item->count_applications <= 49) {
                            $item->sum_price_applications = $pr * 16;
                            $item->sum_price_applications += $wpr * 13;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.2;
                        } elseif ($item->count_applications > 50) {
                            $item->sum_price_applications = $pr * 15;
                            $item->sum_price_applications += $wpr * 12;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.18;
                        } else {
                            $item->sum_price_applications = $pr * 14;
                            $item->sum_price_applications += $wpr * 11;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.15;
                        }


                        $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
                        $item->update();

                    } else {
                        $item->count_applications = $this->ordersRepository->sumOrdersCount($item->date);
                        $item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($item->date);

                        $item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($item->date);
                        $item->returned_applications = $this->ordersRepository->sumReturnedApplications($item->date);
                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date);
                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date);
                        $item->total_applications = $item->returned_applications + $item->done_applications;

                        $pr = $this->ordersRepository->countWithParcelReminder($item->date);
                        $wpr = $this->ordersRepository->countWithoutParcelReminder($item->date);

                        if ($item->count_applications <= 49) {
                            $item->sum_price_applications = $pr * 16;
                            $item->sum_price_applications += $wpr * 13;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date) * 0.2;
                        } elseif ($item->count_applications > 50) {
                            $item->sum_price_applications = $pr * 15;
                            $item->sum_price_applications += $wpr * 12;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date) * 0.18;
                        } else {
                            $item->sum_price_applications = $pr * 14;
                            $item->sum_price_applications += $wpr * 11;
                            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date) * 0.15;
                        }

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

            $item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($dateNow);
            $item->returned_applications = $this->ordersRepository->sumReturnedApplications($dateNow);
            $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow);
            $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow);
            $item->total_applications = $item->returned_applications + $item->done_applications;

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

            $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
            $item->save();

            foreach ($managers as $manager) {
                $manager_item = $this->managersSalaryRepository->createNewModel();
                $manager_item->date = $dateNow;
                $manager_item->manager_id = $manager->id;
                $manager_item->count_applications = $this->ordersRepository->sumOrdersCount($dateNow, $manager->id);
                $manager_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($dateNow, $manager->id);

                $manager_item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($dateNow,$manager->id);
                $manager_item->returned_applications = $this->ordersRepository->sumReturnedApplications($dateNow, $manager->id);
                $manager_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow, $manager->id);
                $manager_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow, $manager->id);
                $manager_item->total_applications = $manager_item->returned_applications + $manager_item->done_applications;

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

                $manager_item->total_price = $manager_item->sum_price_applications + $manager_item->sum_price_additional_sales;
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
                    $managerSalaryAll_item->total_applications = $managerSalaryAll_item->returned_applications + $managerSalaryAll_item->done_applications;

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

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales;
                    $managerSalaryAll_item->update();

                } else {
                    $managerSalaryAll_item->count_applications = $this->ordersRepository->sumOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->count_additional_sales = $this->orderItemsRepository->countAdditionalSales($managerSalaryAll_item->date);

                    $managerSalaryAll_item->in_process_applications = $this->ordersRepository->sumIndefiniteApplications($managerSalaryAll_item->date);
                    $managerSalaryAll_item->returned_applications = $this->ordersRepository->sumReturnedApplications($managerSalaryAll_item->date);
                    $managerSalaryAll_item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->done_applications = $this->ordersRepository->sumDoneOrdersCount($managerSalaryAll_item->date);
                    $managerSalaryAll_item->total_applications = $managerSalaryAll_item->returned_applications + $managerSalaryAll_item->done_applications;

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

                    $managerSalaryAll_item->total_price = $managerSalaryAll_item->sum_price_applications + $managerSalaryAll_item->sum_price_additional_sales;
                    $managerSalaryAll_item->update();
                }
            }
        }
    }
}
