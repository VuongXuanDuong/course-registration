<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'user_name' => 'admin',
                'password' => Hash::make('123456'),
                'is_admin' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User 1',
                'user_name' => 'user1',
                'password' => Hash::make('123456'),
                'is_admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User 2',
                'user_name' => 'user2',
                'password' => Hash::make('123456'),
                'is_admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User 3',
                'user_name' => 'user3',
                'password' => Hash::make('123456'),
                'is_admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        User::query()->insert($users);
    }
}
