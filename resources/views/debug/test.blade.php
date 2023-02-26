@extends('debug.layout')
@section('c')
    <x-debug.test />

    <p>
        view text
        @isset($test)
            {{ $test }}
        @endisset
        @isset($example)
            {{ $example }}
        @endisset
    </p>
@endsection
