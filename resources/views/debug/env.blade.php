@extends('debug.layout')
@section('c')
    <blockquote>
        {{ Request::url() }}
    </blockquote>
    @if (env('APP_ENV') == 'local')
        Local Enviroment:
    @endif

    <p>default DB: {{ DB::getDatabaseName() }}</p>
    <blockquote>
        <p>typ: {{ env('DB_CONNECTION', 'default') }}</p>
        <p>DB IP: {{ env('DB_HOST', 'default') }}</p>
        <p>DB Port: {{ env('DB_PORT', 'default') }}</p>
    </blockquote>
    <br>

    <p>day: {{ date('D') }}</p>
    <p>week: {{ date('W') }}</p>
    <p>month: {{ date('M') }}</p>
    <p>date: {{ date(now()) }}</p>
    <br>
    <p> locale: {{ Lang::locale() }} </p>
    <p> appConfig_locale: {{ Config::get('app.locale') }}, {{ app()->getLocale() }}</p>
@endsection
