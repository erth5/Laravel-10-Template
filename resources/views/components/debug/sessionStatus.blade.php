{{-- use with "with" --}}
<div style="text-align: center">
    @if (session('status'))
        <p> {{ session('status') }} </p>
    @endif
    @if (session('success'))
        <p> {{ session('success') }} </p>
    @endif
    @if (session('error'))
        <p> {{ session('error') }} </p>
    @endif

    @if (session('statusInfo'))
        <p> {{ session('statusInfo') }} </p>
    @endif
    @if (session('statusSuccess'))
        <p> {{ session('statusSuccess') }} </p>
    @endif
    @if (session('statusError'))
        <p> {{ session('statusError') }} </p>
    @endif
</div>

{{-- use with "withErrors", used lang->validation messages --}}
@if (isset($errors))
    @if ($errors->any())
        {{ $errors->first() }}
    @endif

    @if ($errors->any() > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    @endif
@endif
