<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class OrdersController
 * @package App\Http\Controllers\Admin
 */
class OrdersController extends BaseController
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

    /**
     * Получить все заказы и вывести в пагинацию по 15 шт.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('admin.orders.index');
    }

    /**
     * Получить заказ для редактирования.
     *
     * @return Application|Factory|View
     */
    public function edit(): View|Factory|Application
    {
        return view('admin.orders.edit');
    }

    public function export()
    {
        return Excel::download(new OrdersExport(), 'list.xlsx');
    }
}
