<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Services\UtilService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $UtilService;

    public function __construct(
        UtilService $UtilService
    ) {
        $this->UtilService = $UtilService;
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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->UtilService->fillObjectFromRequest(new User(), $request);
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
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->UtilService->fillObjectFromRequest($user, $request, false);
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
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new UsersExport(), 'users.csv');
    }

    public function import()
    {
        Excel::import(new UsersImport(), 'users.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
    public function truncate()
    {
        DB::table('users')->truncate();
        return redirect('/')->with('success', 'Truncate finsished');
    }
}
