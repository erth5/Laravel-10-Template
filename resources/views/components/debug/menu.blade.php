<blockquote>
    <a href="/debug">Overview</a>
    <a href="/debug/debug">Redirect</a>
    <a href="/info/template">Template</a>
</blockquote>
<a href="/info/db">Connection</a>
<a href="/debug/php">PHP-Info</a>
<a href="/debug/env">Environment</a>
<blockquote>

</blockquote>
<a href="/debug/path">Path</a>
<a href="/debug/views">View</a>
<a href="/debug/controllers">Controller</a>
<a href="/debug/models">Model</a>
<blockquote>

    <a href="/debug/config">configValidation</a>
</blockquote>
<blockquote>
    <a href="/info/lang">Language</a>
    <a href="/lang/lang_debug">Language Debug</a>
</blockquote>
<a {{ !Route::has('voyager') ? 'class=disabled' : '' }} href="/admin">Voyager</a>
<a {{ !Route::has('nova.pages.home') ? 'class=disabled' : '' }} href="/nova">Nova</a>
<blockquote></blockquote>
<a {{ !Route::has('horizon') ? 'class=disabled' : '' }} href="/horizon">Horizon</a>
<a {{ !Route::has('telescope') ? 'class=disabled' : '' }} href="/telescope">Telescope</a>
<a {{ !Route::has('route:list') ? 'class=disabled' : '' }} href="/route:list">RouteList</a>
<a {{ !Route::has('log-viewer.index') ? 'class=disabled' : '' }} href="/log-viewer">Log-View</a>
<blockquote></blockquote>
<a {{ !Route::has('l5-swagger.default.api') ? 'class=disabled' : '' }} href="/api/documentation">Swagger</a>
<a {{ !Route::has('l5-swagger.default.docs') ? 'class=disabled' : '' }} href="/docs/api-docs.json">Swagger-JSON</a>
<blockquote></blockquote>
@if (Route::has('login'))
    <a href="{{ route('login') }}">Login</a>
@endif
@if (Route::has('logout'))
    <a href="{{ route('logout') }}">Logout</a>
@endif
@if (Route::has('register'))
    <a href="{{ route('register') }}">Register</a>
@endif
@if (Route::has('password.email'))
    <a href="/forgot-password">Forgot Passwort</a>
@endif
@if (Route::has('dashboard'))
    <a href="{{ route('dashboard') }}">Dashboard</a>
@endif
<blockquote>
</blockquote>
<br>

<a href="/debug/scope">user_all</a>
<blockquote>
    <a href="/user/test">user_test</a>
    <a href="/person/test">person_test</a>
    <a href="/debug/test">debug_test</a>
</blockquote>
<blockquote>
    <a href="/info/user">user->Person</a>
    <a href="/info/person">person->User</a>
    <a href="/info/name">Name</a>
</blockquote>
<blockquote>
    <a href="/info/session">Current Session</a>
    <a href="/info/sessions">Session Data</a>

    <a href="/images"><button @disabled(Route::has('images'))>Image</button></a>
</blockquote>
<blockquote>
    <a href="/debug/status">withStatus</a>
    <a href="/debug/error">withStatusError</a>
</blockquote>
<a href="/permission/role">RolePermission</a>
<a href="/permission/user">UserPermission</a>
<blockquote></blockquote>