<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;

class PersonController extends Controller
{
    public function index()
    {
        // performance: 2 queries->bad
        if (Person::count() == 0)
            return view('debug.user');
        else
            $people = Person::all();
        return view('debug.user', compact('people'));
    }

    /**
     * Set users.names by relationship from people.surname and people.last_name
     * person -> user
     */
    public function adjust()
    {
        $people = Person::all();
        foreach ($people as $person) {
            if ($person->user != null)
                if ($person->user->name != ($person->surname . " " . $person->last_name))
                    Log::warning('name of user [' . $person->surname . "] [" . $person->last_name . '] will adjusted to person, old data: ', [$person->user->name]);
            $person->user->name = ($person->surname . " " . $person->last_name);
            $person->user->save();
        }
    }

    public function destroy(Person $person)
    {
        $person->delete();
        $view = Person::view();
        // dd($view);
        return $view;
    }

    public function test($id = 11)
    {
        /** works */
        // $names =  User::get(array('name'));
        // $names =  User::select('name')->get();
        // dd($names);

        /** works */
        // $person = Person::findOrFail($id);
        // if ($person->user_id == null)
        //     echo 'ist null';
        // else
        //     echo 'ist nicht null';

        // if ($person->has('user_id'))
        //     echo 'hat';
        // else
        //     echo 'hat nicht';

        // if ($person->user_id->exists())
        //     echo ('existiert');
        // else
        //     echo 'existiert nicht';
        // dd('Erfassung vollständig');

        /** works */
        // $person = Person::where('username', 'laraveller')->first();
        // $numberRelatedImages = $person->countRelatedImages($person->id);
        // if ($numberRelatedImages >= 2)
        //     $relatedImages = $person->getRelatedImages($person->id);
        // else
        //     dd($numberRelatedImages);
        // dd($relatedImages);

        /** works */
        // return view('/debug.test')->with(compact('test'))->with('example', $withText);
        // return View::make('/debug.test')->with(compact('test'))->with('example', $withText);

        /** works */
        // $test = Person::peopleOrganized();
        // dd($test);

        /** works */
        // $test = Person::withRelationships()->get();
        // dd($test);

        /** need implementet design */
        $test = Person::peopleAdded();
        return view('debug.person', compact('test'));
    }
}
