<?php

namespace Tests\Template\Databases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use App\Models\Person;
use Database\Seeders\PersonSeeder;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\assertTrue;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsObject;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RelationshipPracticalTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test One to One Relationship User to Person
     * Prüfung mit Variante Factory (Beispiel)
     *  @group data
     * @return void
     */
    public function test_user_has_a_person()
    {
        if (DB::table('people')->count() == 0 && DB::table('users')->count() == 0) {
            $this->seed(PersonSeeder::class);
            echo "database was empty";
        }
        // dd(User::where('name', 'Max Mustermann')->firstOrFail()->person);
        $this->assertEquals("laraveller", User::where('name', 'Max Mustermann')->firstOrFail()->person->username);
    }

    /**
     * Test One to One Relationship User to Person
     * Prüfung mit Variante Factory (Beispiel)
     *  @group data
     * @return void
     */
    public function test_default_person_belongs_to_user()
    {
        if (DB::table('people')->count() == 0 && DB::table('users')->count() == 0)
            $this->seed(PersonSeeder::class);
        // dd(Person::where('username', 'laraveller')->firstOrFail()->person);
        // dd(Person::where('username', 'laraveller')->firstOrFail());
        $this->assertEquals("Max Mustermann", Person::where('username', 'laraveller')->firstOrFail()->user->name);
    }

    /** Test Relationship image to person
     *  @group data
     * @return void
     */
    public function test_default_image_belong_to_person()
    {
        if (DB::table('people')->count() == 0)
            assertTrue(true);
        else {
            $image = Image::where('name', 'Resource_Image_Routes.png')->first();
            assertIsObject($image->person);
        }
    }

    /** Test Relationship from user are compatible with person
     *  @group data
     *@return void
     */
    public function test_images_have_correct_relations_to_user_and_person()
    {
        if (DB::table('people')->count() == 0)
            assertTrue(true);
        $images = Image::all();
        foreach ($images as $image) {
            // dd($image->user);
            if ($image->user != null && $image->person != null)
                assertEquals($image->person->user, $image->user);
        }
        assertTrue(true);
    }

    // /** Test Relationship lang to persond */
    // public function test_person_can_have_language()
    // {
    //     if (DB::table('langs')->count() == 0)
    //         assertTrue(true);
    //     assertIsString(Person::where('username', 'laraveller')->firstOrFail()->lang);
    // }
}
