<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class CategoriesController
 * @package App\Http\Controllers\Admin
 */
class CategoriesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Открыть страницу со всеми категориями.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Открыть страницу создания категории.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Открыть страницу редактирования категории.
     *
     * @return Application|Factory|View
     */
    public function edit()
    {
        return view('admin.categories.edit');
    }
}
