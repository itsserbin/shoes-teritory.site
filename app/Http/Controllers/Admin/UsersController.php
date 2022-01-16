<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    use HasRolesAndPermissions;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(): Factory|View|Application
    {
        return view('admin.users.index');
    }

    public function edit(): Factory|View|Application
    {
        return view('admin.users.edit');
    }

    public function create(): Factory|View|Application
    {
        return view('admin.users.create');

    }
}
