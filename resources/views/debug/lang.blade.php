@extends('debug.layout')
@section('c')

    {{-- Automatic Languages --}}
    {{-- @foreach ($installedLocalesArray as $key => $installedLocales)
        <select id="lang">
            @foreach ($installedLocales as $key => $locale)
                <option value={{ $locale }} {{ app()->getLocale() == $locale ? 'selected' : '' }}>
                    {{ $locale }}
                </option>
            @endforeach
        </select>
    @endforeach --}}

    {{-- Manual Languages --}}
    <select id="lang">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="de" {{ app()->getLocale() == 'de' ? 'selected' : '' }}>Deutsch</option>
        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>France</option>
    </select>

    {{-- mcamera package --}}
    {{-- @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <li>
        @if (LaravelLocalization::getCurrentLocale() != $localeCode)
        <a rel="alternate" hreflang="{{ $localeCode }}"
        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ $localeCode }}
    </a>
    @endif
</li>
@endforeach --}}

    <h3>sessionLocale
        {{ session()->get('locale') }}
    </h3>
    <h3>
        appLocale
        {{ app()->getLocale() }}
    </h3>
    <h3>configLocale
        {{ Config::get('app.locale') }}
    </h3>

    <script type="text/javascript">
        var lang = null;
        var url = "{{ route('langChange') }}";
        var value = null;
        if (document.getElementById('lang') != null) {
            selector = document.getElementById('lang')
            // console.log('lang selector id: ' + document.getElementById('lang'));
            // console.log('lang selector query: ' + document.querySelector('#lang'));
            document.querySelector('#lang').addEventListener('change', function() {
                lang = selector.options[selector.selectedIndex].value
                window.location.href = url + "?lang=" + lang;
                console.log('new language set: ' + selector.options[selector.selectedIndex].value);
            });
        }
    </script>

    @if (isset($data))
        {{-- {{ $data }} --}}
        @forelse ($data as $list)
            @if (is_array($list))
                @foreach ($list as $dat)
                    @if (is_array($dat))
                        <p>
                            @foreach ($dat as $sub)
                                {{ $sub }}
                            @endforeach
                        </p>
                    @elseif (is_bool($dat))
                        <p>{{ $dat }}</p>
                    @else
                        {{ $dat }}
                    @endif
                @endforeach
            @else
                <p> {{ $list }}</p>
            @endif

        @empty
            <p>No Element in data</p>
        @endforelse
    @else
        <p>No Debug Data</p>
    @endif
@endsection
