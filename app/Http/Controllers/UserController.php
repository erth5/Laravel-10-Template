<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Services\UtilsService;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $utilsService;
    public function __construct(
        UtilsService $utilsService
    ) {
        $this->utilsService = $utilsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->utilsService->fillObjectFromRequest(new User, $request);
        $user->saveOrFail();
        return redirect()->route('users.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = $this->utilsService->fillObjectFromRequest($user, $request, false);
        $user->saveOrFail();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return redirect()->route('users.index');
    }



    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportCSV()
    {
        return Excel::download(new UsersExport, 'users.csv');
    }

    public function import()
    {
        Excel::import(new UsersImport, 'users.xlsx');

        return redirect('/')->with('success', 'All good!');
    }

    public function test()
    {
        /** works */
        // $users = User::orderBy('name')->with('roles')->get();
        // return view('debug.role', compact('users'));

        /** works Derzeit kein Anmeldesystem */
        // $dbUser = User::where('name', 'Max Mustermann')->first();
        // $helperUser = Auth::user();
        // $authUser = auth()->user();
        // dd($dbUser . $helperUser . $authUser);
        // return $dbUser->proofUserCan('show_permissions');

        /** works performance: 2 queries->bad*/
        // if (User::first() == null)
        //     $users = null;
        // else {
        //     $users = User::all();
        //     return view('debug.person', compact('users'));
        // }
    }
}
