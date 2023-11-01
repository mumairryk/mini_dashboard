<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Arr;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('password');
        $users = collect([
            [
                'name'  => 'Super Admin',
                'email' =>  'admin@admin.com',
                'phone' =>  '9999999999',
                'password' => Hash::make('password'),
                'admin_type' => 'super-admin',
            ],
            [
                'name'  => 'Admin',
                'email' =>  'a@admin.com',
                'password' => $password,
                'phone' =>  '8888888888',
                'admin_type' => 'admin',
            ],
            [
                'name'  => 'Company Admin',
                'email' =>  'c@admin.com',
                'phone' =>  '7777777777',
                'password' => $password,
                'admin_type' => 'company-admin',
            ],
            [
                'name'  => 'HR Admin',
                'phone' =>  '5555555555',
                'email' =>  'hr@admin.com',
                'password' => $password,
                'admin_type' => 'hr-admin',
            ],
            [
                'name'  => 'HR Assistant Admin',
                'phone' =>  '4444444444',
                'email' =>  'hra@admin.com',
                'password' => $password,
                'admin_type' => 'hr-assistant-admin',
            ]
        ]);
        $statuses = Status::get()->pluck('id')->toArray();
        $users->each(function($user) use($statuses){
            $role = Role::firstWhere('name', $user['admin_type']);
            unset($user['admin_type']);
            $newUser = new User;
            $newUser->fill($user);
            $newUser->status_id = 1;
            $newUser->save();
            $newUser->assignRole($role);
        });

        $user_role = Role::firstWhere('name', 'user');
        User::factory()->count(50)->create()->each(function($user) use($statuses, $password, $user_role){
            $user->password = $password;
            $user->status_id = Arr::random($statuses);
            $user->save();
            $user->assignRole($user_role);
        });
    }
}
