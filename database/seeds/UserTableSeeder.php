<?php

use Illuminate\Database\Seeder;
use app\Models\Role;
use app\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $user = new User();
        $user->name = 'User';
        $user->email = 'martin.odetti@gmail.com';
        $user->password = bcrypt('chajari');
        $user->save();
        $user->roles()->attach($role_user);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'martin.odetti@apilogicsf.com';
        $user->password = bcrypt('chajari');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
