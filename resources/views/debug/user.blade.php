@extends('debug.layout')
@section('c')

    @empty($people)
        <!-- Fehler? -->
        No data
    @endempty

    @isset($people)
        <h3>
            @forelse ($people as $person)
                {{-- {{ $person->surname }}
                {{ $person->last_name }}
                {{ $person->username }}
            
                {{ $person->user()->get('name') }}
                {{ $person->user()->get('email') }} --}}

                @forelse ($people->getAttributes() as $attribute)
                    {{ $attribute }},
                @empty
                    <p>No Columns</p>
                @endforelse
                <blockquote></blockquote>
            @empty
                <p>No Database Entrys</p>
            @endforelse
        </h3>
    @endisset

@endsection