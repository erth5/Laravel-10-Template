{{ Request::url() }}
<p>APP_URL: {{ env('APP_URL') }}</p>
<p>Environment: {{ env('APP_ENV') }}</p>
<p>Default DB: {{ DB::getDatabaseName() }}</p>
<p>Typ: {{ env('DB_CONNECTION', 'default') }}</p>
<p>DB IP: {{ env('DB_HOST', 'default') }}</p>
<p>DB Port: {{ env('DB_PORT', 'default') }}</p>
<br>

<p>day: {{ date('D') }}</p>
<p>week: {{ date('W') }}</p>
<p>month: {{ date('M') }}</p>
Current Time: {{ now() }}
<br>
<p> locale: {{ Lang::locale() }} </p>
<p> appConfig_locale: {{ Config::get('app.locale') }}, {{ app()->getLocale() }}</p>

<p>Server Timezone: {{ date_default_timezone_get() }}</p>
