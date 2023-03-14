<?php

namespace Tests\Template\Unit;

use Tests\TestCase;
use App\Models\Lang;
use App\Models\User;
use App\Models\Image;
use App\Models\Person;
// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RelationshipTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test User has Person
     *
     * @return void
     */
    public function test_user_to_person()
    {
        $user = User::factory(User::class)->create();
        $person = Person::factory(Person::class)->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $person->user);
    }

    /**
     * Test Person is Instance of User
     *
     * @return void
     */
    public function test_person_to_user()
    {
        $user = User::factory(User::class)->create();
        $person = Person::factory(Person::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Person::class, $user->person);
    }


    /**
     * Test Person has several Image
     *
     * @return void
     */
    public function test_person_to_image()
    {
        $person = Person::factory(Person::class)->create();
        $image = Image::factory(Image::class)->create(['person_id' => $person->id]);
        $image = Image::factory(Image::class)->create(['person_id' => $person->id]);

        $this->assertTrue($person->image->contains($image));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $person->image);
    }

    /**
     * Test Person has several Image
     *
     * @return void
     */
    public function test_image_to_person()
    {
        $person = Person::factory(Person::class)->create();
        $image = Image::factory(Image::class)->create(['person_id' => $person]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $image->person);
    }

    /**
     * Test Image is Instance of user
     *
     * @return void
     */
    public function test_image_to_user()
    {
        $user = User::factory(User::class)->create();
        $image = Image::factory(Image::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->image);
    }

    /**
     * Test Person has several Image
     *
     * @return void
     */
    public function test_person_to_lang()
    {
        $person = Person::factory(Person::class)->create();
        $lang = Lang::factory(Lang::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $lang->person);
    }
}
