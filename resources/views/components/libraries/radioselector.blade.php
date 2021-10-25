@props([
    'library' => $library,
    'libraries' => $libraries,
])
<div class="flex flex-row mt-4 bg-blue-100 justify-around">

    @foreach($libraries AS $item)
        <div>
            <input type="radio" id="library_{{ $item->id }}" name="libraries[]" value="{{ $item->id }}"
                @if($item->id === $library->id) CHECKED @endif
            />
            <label for="library_{{ $item->id }}">{{ $item['school']->shortName }}</label>
        </div>

    @endforeach

</div>
