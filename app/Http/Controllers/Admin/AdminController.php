<?php

namespace App\Http\Controllers\Admin;

use App\Models\ManagerSalary;
use App\Repositories\Bookkeeping\ManagersSalaryRepository;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Daaner\TurboSMS\Facades\TurboSMS;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AdminController extends BaseController
{
    private $managersSalaryRepository;
    private $orderItemsRepository;
    private $ordersRepository;
    private $usersRepository;

    /**
     * Display a listing of the resource.
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

    public function index(): Factory|View|Application
    {

//        $dateNow = Carbon::now()->format('Y-m-d');
//
//        $managers = $this->usersRepository->getManagersList();
//        $managerSalaryNow = $this->managersSalaryRepository->getRowsByDate($dateNow);
//        if (count($managerSalaryNow)) {
//            foreach ($managerSalaryNow as $item) {
//                foreach ($managers as $manager) {
//
//                    if ($item->manager_id == $manager->id) {
//                        $item->applications = $this->ordersRepository->sumOrdersCount($item->date, $manager->id);
//                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date, $manager->id);
//                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date, $manager->id);
//                        $item->additional_sales = $this->ordersRepository->sumAdditionalSales($item->date, $manager->id);
//
//                        $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.2;
//                        if ($item->done_applications < 50) {
//                            $item->sum_price_applications = $item->done_applications * 13;
//                        }
//
//                        $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
//                        $item->update();
//                    } else {
//                        $item->applications = $this->ordersRepository->sumOrdersCount($item->date);
//                        $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date);
//                        $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date);
//                        $item->additional_sales = $this->ordersRepository->sumAdditionalSales($item->date);
//                        $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date) * 0.2;
//
//                        if ($item->applications < 50) {
//                            $item->sum_price_applications = $item->applications * 13;
//                        }
//                        $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
//                        $item->update();
//                    }
//                }
//            }
//        } else {
//            $item = $this->managersSalaryRepository->createNewModel();
//            $item->date = $dateNow;
//            $item->applications = $this->ordersRepository->sumOrdersCount($dateNow);
//            $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($dateNow);
//            $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($dateNow);
//            $item->additional_sales = $this->ordersRepository->sumAdditionalSales($dateNow);
//            $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($dateNow) * 0.2;
//
//            if ($item->applications < 50) {
//                $item->sum_price_applications = $item->applications * 13;
//            }
//            $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
//            $item->save();
//
//            foreach ($managers as $manager) {
//                $item = $this->managersSalaryRepository->createNewModel();
//                $item->manager_id = $manager->id;
//                $item->date = $dateNow;
//                $item->applications = $this->ordersRepository->sumOrdersCount($item->date, $manager->id);
//                $item->done_applications = $this->ordersRepository->sumDoneOrdersCount($item->date, $manager->id);
//                $item->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($item->date, $manager->id);
//                $item->additional_sales = $this->ordersRepository->sumAdditionalSales($item->date, $manager->id);
//                $item->sum_price_additional_sales = $this->orderItemsRepository->sumAdditionalSalesMarginality($item->date, $manager->id) * 0.2;
//
//                if ($item->done_applications < 50) {
//                    $item->sum_price_applications = $item->done_applications * 13;
//                }
//                $item->total_price = $item->sum_price_applications + $item->sum_price_additional_sales;
//                $item->save();
//            }
//        }
//        $managerSalaryOld = $this->managersSalaryRepository->getAll($dateNow);
//        $ordersCountNow = $this->ordersRepository->sumOrdersCount($dateNow);
//        $doneOrdersCountNow = $this->ordersRepository->sumDoneOrdersCount($dateNow);
//        $cancelOrdersCountNow = $this->ordersRepository->sumCancelOrdersCount($dateNow);

        return view('admin.dashboard');
    }
}
