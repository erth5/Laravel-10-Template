<p>{{ $image->name }}</p>
@if ($image->remove_time != null)
    <p>deleted at: {{ $image->remove_time }}</p>
    <form action="{{ route('restore image', $image) }}" method="GET">
        <button type="submit">restore</button>
    </form>
@else
    @isset($image->person->username)
        person: {{ $image->person->username }}
    @endisset
    @isset($image->user->name)
        user: {{ $image->user->name }}
    @endisset
    <p>online</p>
    <p>{{ asset('storage/' . $image->path) }}</p>

    <img src="{{ asset('storage/' . $image->path . $image->name) }}" width='250' />

    <form method="POST" action="{{ route('destroy image', $image) }}">
        @csrf
        @method('DELETE')
        <button type="submit" value="submit">remove</button>
    </form>

    <form method="POST" action="{{ route('rename image', [$image]) }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="rename"> .{{ $image->extension }}
        <button type="submit">rename</button>
    </form>

    <form method="POST" action="{{ route('update image', $image) }}" enctype="multipart/form-data"
        style="display: inline-block">
        @csrf
        @method('PUT')
        <input type="file" name="image" @error('image') is-invalid @enderror>
        @error('image')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <button type="submit" value="image">update</button>
    </form>
@endif
