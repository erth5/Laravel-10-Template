<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('SUPER_ADMIN_EMAIL') && env('SUPER_ADMIN_PASSWORD')) {
            $super_admin = User::create([
                'name' => 'super.admin',
                'email' => env('SUPER_ADMIN_EMAIL'),
                'email_verified_at' => now(),
                'password' => env('SUPER_ADMIN_PASSWORD')
            ]);
        }

        if (env('DEVELOPER_EMAIL') && env('DEVELOPER_PASSWORD')) {
            $developer = User::create([
                'name' => 'admin.developer',
                'email' => env('DEVELOPER_EMAIL'),
                'email_verified_at' => now(),
                'password' => env('DEVELOPER_PASSWORD')
            ]);
        }

        if (env('USER_EMAIL') && env('USER_PASSWORD')) {
            $user = User::create([
                'name' => 'default.user',
                'email' => env('USER_EMAIL'),
                'email_verified_at' => null,
                'password' => env('USER_PASSWORD'),
            ]);
        }

        if (env('TRASHED_EMAIL') && env('TRASHED_PASSWORD')) {
            $trashed = User::create([
                'name' => 'trashed.Leila Hold',
                'email' => env('TRASHED_EMAIL'),
                'email_verified_at' => null,
                'password' => env('TRASHED_PASSWORD'),
                'deleted_at' => now()
            ]);
        }
    }
}
