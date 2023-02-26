@extends('image.layout')
@section('image_views')

    <h2>Image Upload</h2>

    <form action="{{ route('store image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="inputImage">Image:</label>
        <input type="file" name="image" id="inputImage" @error('image') is-invalid @enderror">

        @error('image')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <button type="submit">upload</button>
    </form>

    <form action="{{ route('debug image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="inputImage">Debug:</label>
        <input type="file" name="debug">
        <button type="submit">Debug</button>
    </form>
@endsection
