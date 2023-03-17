<?php

namespace Tests\Template\Databases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Person;
use App\Actions\AdjustPerson;
use Database\Seeders\UserSeeder;
use Database\Seeders\PersonSeeder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\assertEquals;
use App\Http\Controllers\Debug\PersonController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class DatabaseTest extends TestCase
{
    /** Migriert vor dem Test, Entfernt alles nach dem Test */
    // use DatabaseMigrations;

    /** Migriert vor und nach dem Test */
    // use RefreshDatabase;

    /** fuer SQLite, Speichert den Zustand zwischen und stellt ihn wieder her */
    use DatabaseTransactions;

    /** Setzt die Authentifizierung und andere Middlewares außer Kraft */
    // use WithoutMiddleware;

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_user_name()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed('PersonSeeder');
            $this->seed(UserSeeder::class);
        }
        $defaultUser = User::where('name', "=", 'Max Mustermann')->firstOrFail();
        assertEquals('Max Mustermann', $defaultUser->name);
    }

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_person_username()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed(PersonSeeder::class);
        }
        $defaultPerson = Person::where('username', "=", 'laraveller')->first();
        assertEquals("laraveller", $defaultPerson->username);
    }

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_person_last_name()
    {
        if (DB::table('people')->count() == 0)
            $this->seed('PersonSeeder');
        $this->assertDatabaseHas('people', [
            'last_name' => 'Mustermann',
        ]);
    }

    /**
     * Teste ob ein Nutzer angelegt werden kann
     * Testet nicht auf Basis von softDeletes
     * @group data
     * @return void
     */
    public function test_db_can_create_and_delete_user()
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
        $user->forceDelete();
        $this->assertModelMissing($user);
    }

    /**
     * set users name to surname and last name from person .
     *
     * @return void
     */
    public function test_can_adjust_person()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed('PersonSeeder');
        }
        $adjusting = (new AdjustPerson)->handle();
        assertEquals(
            'Lord Kennedy',
            Person::where('username', 'thespasst')
                ->first()->user->name
        );
    }
}
