<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

/**
 * Class ProductsController
 * @package App\Http\Controllers\Admin
 */
class ProductsController extends BaseController
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('admin.product.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.product.create');
    }


    /**
     * @return Application|Factory|View|Response
     */
    public function edit(): View|Factory|Response|Application
    {
        return view('admin.product.edit');
    }
}
