<?php

namespace App\Http\Controllers\Admin\Bookkeeping;


use App\Repositories\Bookkeeping\CostsRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CostsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {
//        dd(Carbon::now()->startOfMonth());
//        $test = new CostsRepository();
//        dd($test->generalStatistic());
        return view('admin.bookkeeping.costs.index');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.bookkeeping.costs.create');
    }

    public function edit(): Factory|View|Application
    {
        return view('admin.bookkeeping.costs.edit');
    }
}
