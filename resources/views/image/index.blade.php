@extends('image.layout')
@section('image_views')

    @if ($message = Session::get('success'))
        {{-- <strong style="text-align: center">{{ $message }}</strong> --}}
        <img src="image/{{ Session::get('image') }}">
        @php
            $image = session::get('image');
        @endphp
    @endif

    @isset($images)
        <form action="/images/clear">
            <button>clear</button>
        </form>
        @forelse ($images as $image)
            <div style="display: inline-block">
                <x-image.show :image=$image />
            </div>
        @empty
            <p>No Images Saved</p>
        @endforelse
    @else
        <p>No Images object Saved</p>
    @endisset
@endsection
