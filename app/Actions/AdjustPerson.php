<?php

namespace App\Actions;

use App\Models\Person;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class AdjustPerson
{
    /**
     * Set users.names by relationship from people.surname and people.last_name
     * person -> user
     */
    use AsAction;

    public function handle()
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
}
