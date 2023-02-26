@extends('debug.layout')
@section('c')
    @isset($data)
        @if (is_array($data))
            @forelse ($data as $keyOne => $stageOne)
                @if (is_array($stageOne))
                    <ul>
                        @forelse ($stageOne as $keyTwo => $stageTwo)
                            @if (is_array($stageTwo))
                                @forelse ($stageTwo as $keyThree => $stageThree)
                                    @if (is_array($stageThree))
                                        @forelse ($stageThree as $keyFour => $stageFour)
                                            <li style="color: red"> {{ $stageFour . $keyFour }} </li>
                                        @empty
                                        @endforelse
                                        <blockquote></blockquote>
                                    @else
                                        <li style="color: yellow"> {{ $stageThree . $keyThree }}</li>
                                    @endif
                                @empty
                                @endforelse
                                <blockquote></blockquote>
                            @else
                                <li style="color: yellowgreen">{{ $stageTwo . $keyTwo }}</li>
                            @endif
                        @empty
                        @endforelse
                        <blockquote></blockquote>
                    </ul>
                @else
                    <p style="color: green">{{ $stageOne . $keyOne }}</p>
                @endif
            @empty
            @endforelse
            <blockquote></blockquote>
        @else
            {{ $data }}
        @endif
    @endisset

    @if (isset($stage))
    @else
    @endif
@endsection
