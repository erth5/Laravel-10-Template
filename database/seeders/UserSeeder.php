<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
        if (config()->has('users')) {
            $users = config()->get('users');
            if (!$users) {
                return;
            }

            foreach ($users as $seedUser) {
                $startUser = User::create([
                    'name' => $seedUser['name'],
                    'email' => $seedUser['email'],
                    'email_verified_at' => now(),
                    'password' => bcrypt($seedUser['password']),
                    'abbreviation' => $seedUser['abbreviation'],
                ]);

                $roles = $seedUser['roles'];
                if (!empty($roles)) {
                    if (in_array('all', $roles)) {
                        $startUser->assignRole(Role::all());
                    } else {
                        foreach ($roles as $key => $role) {
                            $startUser->assignRole($role);
                        }
                    }
                }
                if (isset($seedUser['softdeleted'])) {
                    $startUser->delete();
                }
                $startUser->saveOrFail();
            }
        }
    }
}
