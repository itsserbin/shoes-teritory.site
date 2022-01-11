<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class ClientsController
 * @package App\Http\Controllers\Admin
 */
class ClientsController extends BaseController
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
     * Вывести всех клиентов в пагинации по 15 шт.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('admin.clients.index');
    }

    /**
     * Получить клиента по ID.
     *
     * @return Application|Factory|View
     */
    public function edit(): View|Factory|Application
    {
        return view('admin.clients.edit');
    }
}
