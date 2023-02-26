@extends('debug.layout')
@section('c')
    @if (isset($sessions))
        <p>first is current</p>
        <table>
            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>ip_address</th>
                <th>user_agent</th>
                <th>payload</th>
                <th>last_activity</th>
            </tr>
            @forelse ($sessions as $session)
                <tr>
                    <td> {{ $session->id }} </td>
                    <td> {{ $session->user_id }} </td>
                    <td> {{ $session->ip_address }} </td>
                    <td> {{ $session->user_agent }} </td>
                    <td> {{ $session->payload }} </td>
                    <td> {{ $session->last_activity }} </td>
                </tr>
            @empty
                <p>no entrys</p>
            @endforelse
        </table>
    @else
        <p>no entrys</p>
    @endif
@endsection
