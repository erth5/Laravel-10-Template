<?php

namespace App\Http\Controllers\Debug;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function test()
    {
        // /** works performance: 2 queries->bad*/
        // if (User::first() == null)
        //     $users = null;
        // else {
        //     $users = User::all();
        //     return view('debug.person', compact('users'));
        // }

        /** need auth */
        // $dbUser = User::where('name', 'Max Mustermann')->first();
        // $helperUser = Auth::user();
        // $authUser = auth()->user();
        // dd($dbUser . $helperUser . $authUser);
        // return $dbUser->proofUserCan('show_permissions');

        /** works */
        // $users = User::orderBy('name')->with('roles')->get();
        // return view('debug.role', compact('users'));
    }
}
