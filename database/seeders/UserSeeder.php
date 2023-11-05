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
        $super_admin = User::factory()->create([
            'name' => 'super.admin',
            'email' => env('SUPER_ADMIN_EMAIL'),
            'email_verified_at' => now(),
            'password' => env('SUPER_ADMIN_PASSWORD')
        ]);

        $developer = User::factory()->create([
            'name' => 'admin.developer',
            'email' => env('DEVELOPER_EMAIL'),
            'email_verified_at' => now(),
            'password' => env('DEVELOPER_PASSWORD')
        ]);

        $user = User::factory()->create([
            'name' => 'trashed.Leila Hold',
            'email' => env('USER_EMAIL'),
            'email_verified_at' => null,
            'password' => env('USER_PASSWORD'),
            'deleted_at' => now()
        ]);
    }
}
