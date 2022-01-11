<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\HasRolesAndPermissions;

class RolesColroller extends BaseController
{
    use HasRolesAndPermissions;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.options.roles.index', [
            'roles' => $roles
        ]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('admin.options.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::find($id);
        $role->permissions()->detach();

        $permissions = $request->input('permissions');
        if ($permissions) {
            foreach ($permissions as $permission) {
                $role->givePermissionsTo($permission);
            }
        }

        $data = $request->except('permissions');
        $role->update($data);

        return back();
    }
}
