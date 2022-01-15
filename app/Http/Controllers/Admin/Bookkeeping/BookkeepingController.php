<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

use App\Models\Bookkeeping\Costs;
use App\Models\Bookkeeping\Profit;
use App\Models\Orders;

class BookkeepingController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        $costs = Costs::orderBy('created_at', 'DESC')->paginate(15);
//        $CostsInJustAWeek = Costs::orderBy('created_at', 'desc')
//            ->select('total')
//            ->get(7)
//            ->sum('total');
//
//        $CostsInJustAWeek = Costs::orderBy('created_at', 'desc')
//            ->select('total')
//            ->get(7)
//            ->sum('total');
//
//        $orders = Orders::where('status', 'Выполнен')
//            ->orderBy('created_at', 'desc')
//            ->select('id', 'name', 'product_id', 'phone', 'trade_price', 'sale_price', 'updated_at','created_at')
//            ->paginate(15);

//        $SaleSumInJustAThreeDays = Orders::where('status', 'Выполнен')
//            ->orderBy('created_at', 'desc')
//            ->select('sale_price')
//            ->get(Carbon::today()->subDays(3))
//            ->sum('sale_price');
//
//        $TradeSumInJustAThreeDays = Orders::where('status', 'Выполнен')
//            ->orderBy('created_at', 'desc')
//            ->select('trade_price')
//            ->get(Carbon::today()->subDays(3))
//            ->sum('trade_price');
//        $ProfitOrdersInJustAThreeDays = $SaleSumInJustAThreeDays - $TradeSumInJustAThreeDays;

//        $SaleSumInJustAWeek = Orders::where('status', 'Выполнен')
//            ->orderBy('created_at', 'desc')
//            ->select('sale_price')
//            ->get(Carbon::today()->subDays(7))
//            ->sum('sale_price');
//
//        $TradeSumInJustAWeek = Orders::where('status', 'Выполнен')
//            ->orderBy('created_at', 'desc')
//            ->select('trade_price')
//            ->get(Carbon::today()->subDays(7))
//            ->sum('trade_price');
//        $ProfitOrdersInJustAWeek = $SaleSumInJustAWeek - $TradeSumInJustAWeek;

//        $SaleSumInJustAMonth = Orders::whereMonth('created_at', Carbon::now()->format('m'))
//            ->where('status', 'Выполнен')
//            ->select('sale_price')
//            ->get()
//            ->sum('sale_price');

//        $TradeSumInJustAMonth = Orders::whereMonth('created_at', Carbon::now()->format('m'))
//            ->where('status', 'Выполнен')
//            ->select('trade_price')
//            ->get()
//            ->sum('trade_price');
//        $ProfitOrdersInJustAMonth = $SaleSumInJustAMonth - $TradeSumInJustAMonth;

//        $profits = Profit::paginate(15);
//        $ProfitInJustAWeek = Profit::orderBy('created_at', 'desc')
//            ->select('marginality')
//            ->get(7)
//            ->sum('marginality');

        return view('admin.bookkeeping.index');
    }
}
