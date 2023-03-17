<?php

namespace App\Http\Controllers\Debug;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
    public function test($id = 1)
    {
        // /** need pagination, performance: 2 queries->bad */
        // if (Person::count() == 0)
        //     return view('debug.user');
        // else
        //     $people = Person::all();
        // return view('debug.user', compact('people'));

        /** works */
        // $view = Person::view();
        // return $view;

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

        /** works */
        // $test = Person::peopleAdded();
        // return view('debug.person', compact('test'));
    }
}
