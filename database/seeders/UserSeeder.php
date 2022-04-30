<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = Role::where('slug', 'administrator')->first();
        $manager = Role::where('slug', 'manager')->first();

        $showOrders = Permission::where('slug', 'show-orders')->first();
        $admin = Permission::where('slug', 'admin')->first();

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('secret');;
        $user->save();
        $user->roles()->attach($administrator);
        $user->permissions()->attach($admin);
    }
}
