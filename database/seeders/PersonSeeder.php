<?php

namespace Database\Seeders;

use App\Models\Lang;
use App\Models\User;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** This Seeder needs */
        $this->call(LangSeeder::class);

        // Default Demo User
        $defautPerson = Person::factory()->create([
            'user_id' => $user = User::factory()->create([
                'name' => 'Max Mustermann',
                'email' => 'fdsdwp@protonmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => token_name(10)
            ]),
            'surname' => 'Max',
            'last_name' => 'Mustermann',
            'username' => 'laraveller',
        ]);

        $unadjustedPerson = Person::factory()->create([
            'user_id' => User::factory()->create([
                'name' => 'Viola Rett',
                'email' => 'xzm07930@xcoxc.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => token_name(10)
            ]),
            'surname' => 'Lord',
            'last_name' => 'Kennedy',
            'username' => 'thespasst',
        ]);

        $lang = Lang::where('abbreviation', 'de')->first();
        $defautPerson->lang()->attach($lang);

        $lang = Lang::where('abbreviation', 'en')->first();
        $defautPerson->lang()->save($lang);

        /**
         * Variante: Factory
         * Generierung von Person zugehöriger User in der Factory
         */
        // Beispiel Einträge ohne Person
        User::factory(1)->create();
        // Beispieleinträge
        Person::factory(1)->create();

        /**
         * Variante: Seeder
         * Generierung zugehöriger User im Seeder
         * */
        // // Beispiel Einträge ohne Person
        // User::factory(3)->create();
        // // Beispieleinträge
        // User::factory(2)->create()->each(function ($user) {
        //     $person = Person::factory()->make();
        //     $user->person()->save($person);
        // });
    }
}
