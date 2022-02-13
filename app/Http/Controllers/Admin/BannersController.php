<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BannersController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('admin.banners.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.banners.create');
    }

    /**
     * @return Application|Factory|View
     */
    public function edit(): View|Factory|Application
    {
        return view('admin.banners.edit');
    }
}
