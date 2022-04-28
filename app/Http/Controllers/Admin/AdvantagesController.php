<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AdvantagesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {
        return view('admin.options.advantages.index');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.options.advantages.create');
    }

    public function edit(): Factory|View|Application
    {
        return view('admin.options.advantages.edit');
    }
}
