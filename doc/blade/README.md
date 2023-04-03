@isset($person)
    @forelse ($person->getAttributes() as $attribute)
    <Form>
            @if (in_array($attribute, $user))
            @else
            @endif
    </Form>
    @empty
    @endforelse
@else
@endisset

@foreach ($user->getAttributes() as $val)