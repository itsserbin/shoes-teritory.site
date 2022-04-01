<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProvidersController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        return view('admin.bookkeeping.providers.index');
    }

    /**
     * Показать страницу создания поставщика.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.bookkeeping.providers.create');
    }

    /**
     * @return View|Factory|Application
     */
    public function edit(): View|Factory|Application
    {
        return view('admin.bookkeeping.providers.edit');
    }
}
