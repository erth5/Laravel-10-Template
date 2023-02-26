@extends('debug.layout')
@section('c')
    @forelse ($connections as $connection)
        <p>{{ $connection }}</p>
    @empty
    @endforelse
    @if (DB::connection()->getPdo())
    Successfully connected to the main database =>
        {{ DB::connection()->getDatabaseName() }}
    @endif
@endsection
