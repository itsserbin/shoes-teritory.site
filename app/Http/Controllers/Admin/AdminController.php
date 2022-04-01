<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Bookkeeping\CostsRepository;
use App\Repositories\Bookkeeping\ProfitsRepository;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AdminController extends BaseController
{
    private $ordersRepository;
    private $orderItemsRepository;
    private $costsRepository;
    private $profitsRepository;
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
        $this->costsRepository = app(CostsRepository::class);
        $this->profitsRepository = app(ProfitsRepository::class);
    }

    public function index(): Factory|View|Application
    {
//        dd($this->orderItemsRepository->sumProfitByDate('2022-03-17'));
//        dd($this->orderItemsRepository->sumRefundsByDate('2022-03-17'));
        return view('admin.dashboard');
    }
}
