<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

use App\Repositories\Bookkeeping\BookkeepingRepository;

class ProductStatisticsController extends BaseController
{
    private $BookkeepingRepository;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->BookkeepingRepository = app(BookkeepingRepository::class);
    }

    public function index()
    {
        $done_orders = $this->BookkeepingRepository->getDoneOrdersWithPaginate(15);

        return view('admin.bookkeeping.product-statistics.index', [
            'done_orders' => $done_orders,
        ]);
    }
}
