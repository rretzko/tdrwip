@props([
    'librarymediatypeid',
    'librarymediatypes'
])
<div class="flex flex-row justify-around bg-indigo-100">

    @foreach($librarymediatypes AS $librarymediatype)
        <div>
            <input type="radio" id="compositiontype_id_{{ $librarymediatype->id }}"
                   name="compositiontypes[]"
                   value="{{ $librarymediatype->id }}"
                   @if($librarymediatype->id == $librarymediatypeid) CHECKED @endif
            />
            <label for="compositiontype_id_1">{{ ucwords($librarymediatype->descr) }}</label>
        </div>
    @endforeach
</div>
