<h3>
    @isset($users)
        <table>
            <tr>
                <th>user</th>
                <th>roles</th>
                <th>permissions</th>
            </tr>
            @forelse ($users as $user)
                <tr>
                    <td> {{ $user->name }}</td>
                    <td>{{ $user->prename }}</td>
                    <td style="word-break:break-all;word-wrap:break-word">{{ $user->getRoleNames() }}</td>
                    <td style="word-break:break-all;word-wrap:break-word">{{ $user->getPermissionNames() }}</td>
                </tr>
            @empty
                <p>No Database Entrys</p>
            @endforelse
        </table>
    @endisset
    <blockquote></blockquote>
    <div style="float:left">
        @isset($roles)
            <table>
                <tr>
                    <th>role</th>
                    <th>permission</th>
                </tr>
                @forelse ($roles as $role)
                    <tr>
                        <td> {{ $role->name }} </td>
                        {{-- <td>{{ $role->permissions }}</td> --}}
                        <td>
                            <ul>
                                @forelse ($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ul>
                        </td>
                    </tr>
                @empty
                    -
                @endforelse
            </table>
        @endisset
    </div>
    @isset($permissions)
        <table>
            <tr>
                <th>all permissions</th>
            </tr>
            @forelse ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                </tr>
            @empty
                -
            @endforelse
        </table>
    @endisset

    @isset($roles)
        <table>
            <tr>
                <th>all roles</th>
            </tr>
            @forelse ($roles as $rol)
                <tr>
                    <td>{{ $rol->name }}</td>
                </tr>
            @empty
                -
            @endforelse
        </table>
    @endisset
</h3>
