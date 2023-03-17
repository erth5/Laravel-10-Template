<?php

namespace App\Http\Controllers\Helper;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

/** Verarbeiten von Berechtigungen
 * @param userID $request->id NutzerID des gewählten Nutzers
 * @param roleID $request->id RollenID des gewählten Nutzers
 * @param newPermission $request->add Berechtigung zum hinzufügen
 * @param oldPermission $request->del Berechtigung zum entfernen
 *
 * @internal user gewählter Nutzer
 * @internal role gewählte Nutzerrolle
 * @internal permissions alle Berechtigungen
 */
class PermissionAndRoleController extends Controller
{
    use HasRoles;

    public $userID;
    public $user;
    public $role;

    public function role(Request $request)
    {
        // dd($request);
        if ($request->id != null) {
            $roleID = $request->id;
            $role = Role::where('id', $roleID)->with('permissions')->first();
        }

        // Vergeben und entfernen von Berechtigungen
        if ($request->add != null && $request->add != "null")
            $role->givePermissionTo($request->add);
        if ($request->del != null && $request->del != "null")
            $role->revokePermissionTo($request->del);

        $permissions = Permission::all();
        $roles = Role::with('permissions')->get();
        // dd($role);
        return view('permission.index')->with([
            'role' => $role ?? null,
            'users' => $users ?? null
        ])
            // ->with(compact('users'))
            ->with(compact('roles'))
            ->with(compact('request'))
            ->with(compact('permissions'));
    }

    public function user(Request $request)
    {
        if ($request->id != null) {
            $userID = $request->id;
            $user = User::where('id', $userID)->with('permissions')->first();
        }

        /**
         *  null - das Feld ist wird nicht angezeigt -> null
         *  "null" im Feld steht kein Wert -> "null"
         */

        if ($request->add != null && $request->add != "null")
            $user->addPermission($request->add);

        if ($request->del != null && $request->del != "null")
            $user->removePermission($request->del);

        $permissions = Permission::all();
        $users = User::with('permissions')->get();
        return view('permission.index')->with([
            'user' => $user ?? null,
            'roles' => $roles ?? null
        ])
            ->with(compact('users'))
            ->with(compact('permissions'))
            ->with(compact('request'))
            ->with('status', 'user permission edit successful loaded');
    }
}
