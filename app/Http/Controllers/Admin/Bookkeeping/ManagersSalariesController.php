<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ManagersSalariesController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('admin.bookkeeping.managers-salaries.index');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.bookkeeping.managers-salaries.create');
    }
}
