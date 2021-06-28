@props([
'currentvalue' => 0,
'immediate' => false,
'label',
'for',
'options',
'placeholder' => ""
])

<div >
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ ucwords($label) }}</label>
    <select @if($immediate) wire:model @else wire:model.defer @endif ="{{ $for }}" id="{{ $for }}" name="{{ $for }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >

        @if($placeholder)
            <option value="" disabled>{{ $placeholder }}</option>
        @endif

        @foreach($options AS $key => $value)
            <option
                value="{{ (is_object($value)) ? $value->id : $key }}"
                {{ (((is_object($value)) ? $value->id : $key) == $currentvalue) ? 'SELECTED' : '' }}
            >
                {{ is_object($value) ? $value->descr : $value }}

            </option>
        @endforeach
        @error($for)
        <p class="mt-2 text-sm text-red-600" id="{{ $for }}-error">
            {{ $message }}
        </p>
        @enderror

    </select>
</div>
