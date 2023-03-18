<?php

namespace Tests\Template\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test User CRUD operations.
     * Needs: Auth functionality
     */
    public function test_usersIndex(): void
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    // public function test_usersCreate(): void
    // {
    // }

    public function test_usersStore(): void
    {
        $password = $this->faker->password;
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $response = $this->post('/users', $userData);
        $response->assertStatus(302); // Redirect status
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_usersShow(): void
    {
        $user = User::factory(User::class)->create();
        $user->saveOrFail();
        $response = $this->get('/users/'.$user->id);
        $response->assertStatus(200);
    }

    // public function test_Edit(): void
    // {
    // }
    // public function test_usersUpdate(): void
    // {
    // }
    public function test_Destroy(): void
    {
        /* Nutzer abfragen */
        $response = $this->get('/users/1');
        $response->assertStatus(404);

        /* Nutzer erstellen */
        $user = User::factory(User::class)->create();
        $user->saveOrFail();

        /* Nutzer abfragen */
        $response = $this->get('/users/'.$user->id);
        $response->assertStatus(200);
        $this->assertTrue(User::where('email', $user->email)->exists());

        /* Nutzer löschen */
        $response = $this->delete('/users/'.$user->id);
        $response->assertStatus(302);

        /* Nutzer abfragen */
        $response = $this->get('/users/'.$user->id);
        $response->assertStatus(404);
        $this->assertFalse(User::where('email', $user->email)->exists());
    }
}
