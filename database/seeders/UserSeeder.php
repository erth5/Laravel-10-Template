<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deleted User
        User::factory()->create([
            'name' => 'Leila Hold',
            'email' => 'leilasTrash@trashmail.de',
            'email_verified_at' => null,
            'remember_token' => token_name(10),
            'password' => bcrypt('leilas_password'),
            'deleted_at' => now(),
        ]);
    }
}
