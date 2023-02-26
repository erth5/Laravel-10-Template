<blockquote>
    <a href="/debug">Overview</a>
    <a href="/debug/debug">Redirect</a>
    <a href="/info/template">Template</a>
</blockquote>
<a href="/info/db">Connection</a>
<a href="/debug/php">PHP-Info</a>
<blockquote>
    <a href="/debug/env">EnvironmentPart</a>
    <a href="/debug/env2">Environment</a>
</blockquote>

<a href="/debug/path">Path</a>
<a href="/debug/views">View</a>
<a href="/debug/controllers">Controller</a>
<a href="/debug/models">Model</a>
<blockquote></blockquote>
<a href="/debug/config">configValidation</a>
<a href="/info/lang">Language</a>
<a href="/lang/lang_debug">{{ __('debug.lang_debug') }}</a>
<a href="/info/timezone">TimeZone</a>
<blockquote></blockquote>
<a href="/route:list">RouteList</a>
<a @if (env('TELESCOPE')) @else
class="disabled" @endif href="/telescope">Telescope</a>
<a @if (env('HORIZON')) @else class="disabled" @endif href="/horizon">Horizon</a>
<a href="/log-viewer">Log-View</a>
<a @if (env('SWAGGER')) @else class="disabled" @endif href="/api/documentation">Swagger</a>
<a @if (env('SWAGGER')) @else class="disabled" @endif href="/docs/api-docs.json">Swagger-JSON</a>
<a @if (env('VOJAGER')) @else class="disabled" @endif href="/admin">Voyager</a>
<blockquote></blockquote>
<br>

<a href="/index/test"> {{ __('debug.index') }} </a>
<a href="/debug/scope">Scope</a>
<blockquote>
    <a href="/debug/test"> {{ __('debug.test_debug') }} </a>
    <a href="/person/adjust">{{ __('debug.test_action') }}</a>

    <a href="/user/test"> {{ __('debug.test_user') }} </a>
    <a href="/person/test"> {{ __('debug.test_person') }} </a>
</blockquote>
<blockquote>
    <a href="/info/user">user->Person</a>
    <a href="/info/person">person->User</a>
    <a href="/info/name">Name</a>
</blockquote>
<blockquote>
    <a href="/debug/session">Current Session</a>
    <a href="/debug/sessions">Session Data</a>
    <a href="/images">Image</a>
</blockquote>
<blockquote>
    <a href="/debug/status">Status Message</a>
    <a href="/debug/error">Error Message</a>
</blockquote>
<a href="/permission/role">RolePermission</a>
<a href="/permission/user">UserPermission</a>
