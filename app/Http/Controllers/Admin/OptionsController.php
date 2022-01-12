<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\OptionsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OptionsController extends BaseController
{
    private $OptionsRepository;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->OptionsRepository = app(OptionsRepository::class);
    }

    /**
     * Получить основные настройки.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.options.index');
    }

    /**
     * Получить скрипты.
     *
     * @return Application|Factory|View
     */
    public function scripts()
    {
        return view('admin.options.scripts.index');
    }
}
