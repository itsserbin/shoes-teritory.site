<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    use HasRolesAndPermissions;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::paginate(15);

        return view('admin.options.users.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.options.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $permissions = $request->input('permissions');
        $role = $request->input('role');
        $user->permissions()->detach();
        $user->roles()->detach();
        $user->roles()->attach($role);

        if ($permissions) {
            foreach ($permissions as $permission) {
                $user->givePermissionsTo($permission);
            }
        }
        $user->update();

        return back();
    }
}
