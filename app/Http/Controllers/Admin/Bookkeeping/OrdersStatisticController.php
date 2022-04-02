<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrdersStatisticController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {
        return view('admin.bookkeeping.orders-statistics.index');
    }
}
