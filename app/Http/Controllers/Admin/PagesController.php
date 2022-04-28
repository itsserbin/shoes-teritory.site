<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PagesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {
        return view('admin.pages.index');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.pages.create');
    }

    public function edit(): Factory|View|Application
    {
        return view('admin.pages.edit');
    }
}
