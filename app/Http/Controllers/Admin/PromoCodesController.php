<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromoCodesController extends BaseController
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
        return view('admin.promo-codes.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.promo-codes.create');
    }


    /**
     * @return Application|Factory|View|Response
     */
    public function edit(): View|Factory|Response|Application
    {
        return view('admin.promo-codes.edit');
    }
}
