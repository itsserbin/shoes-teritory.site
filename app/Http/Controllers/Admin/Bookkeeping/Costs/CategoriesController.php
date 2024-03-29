<?php

namespace App\Http\Controllers\Admin\Bookkeeping\Costs;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoriesController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('admin.bookkeeping.costs.categories.index');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.bookkeeping.costs.categories.create');
    }

    public function edit(): Factory|View|Application
    {
        return view('admin.bookkeeping.costs.categories.edit');
    }
}
