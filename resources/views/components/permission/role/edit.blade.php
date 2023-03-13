<form action="/permission/role" method="POST">
    @csrf
    @isset($roles)
        <fieldset>
            <label for="roles">Rolle auswählen</label>
            <select name="id">
                <option value=null>select one</option>
                @forelse ($roles as $rol)
                    <option @isset($role) {{ $role->id == $rol->id ? 'selected' : '' }} @endisset
                        value={{ $rol->id }}>{{ $rol->name }}
                    </option>
                @empty
                @endforelse
            </select>
            <label>Bestätigen</label>
            <button type="submit" name="" value="">Wählen</button>
        </fieldset>
    @endisset

    @isset($role)
        <fieldset>
            <label for="del">Berechtigung auswählen:</label>
            <select name="del" id="del">
                <option value=null>select role:</option>
                @forelse ($role->permissions as $permission)
                    <option value={{ $permission->name }}>{{ $permission->name }}</option>
                @empty
                @endforelse
            </select>
            <button type="submit" value="">Berechtigung entfernen</button>
        </fieldset>
        @isset($permissions)
            <fieldset>
                <label for="add">Berechtigung auswählen:</label>
                <select name="add" id="add">
                    <option value=null>Berechtigung auswählen:</option>
                    @forelse ($permissions as $permission)
                        {{-- $permission, $role->permissions --}}
                        @if (!$role->permissions->contains('name', $permission->name))
                            <option value={{ $permission->name }}>{{ $permission->name }}</option>
                        @endif
                    @empty
                    @endforelse
                </select>
                <button type="submit" value="submit">Berechtigung hinzufügen</button>
            </fieldset>
        @endisset
    @endisset
</form>
