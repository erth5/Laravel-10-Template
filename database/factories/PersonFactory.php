<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'surname' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->userName(),
        ];
    }

    /**
     * Variante: Seeder
     * Generierung zugehöriger User im Seeder
     * - Zugehöriger User muss angegeben werden
     * + Richtige Zuordnung
     * @return array<string, mixed>
     */
    // public function definition()
    // {
    //     return [
    //         'surname' => $this->faker->firstName(),
    //         'last_name' => $this->faker->lastName(),
    //         'username' => $this->faker->userName(),
    //     ];
    // }
}
