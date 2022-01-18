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

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {


//        $managerSalaryOld = $this->managersSalaryRepository->getAll($dateNow);
//        $ordersCountNow = $this->ordersRepository->sumOrdersCount($dateNow);
//        $doneOrdersCountNow = $this->ordersRepository->sumDoneOrdersCount($dateNow);
//        $cancelOrdersCountNow = $this->ordersRepository->sumCancelOrdersCount($dateNow);

        return view('admin.dashboard');
    }
}
