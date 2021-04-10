@props([
'label',
'for',
'options',
])

<div>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ ucwords($label) }}</label>
    <select wire:model.defer="{{ $for }}" id="{{ $for }}" name="{{ $for }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

        @foreach($options AS $key => $value)
            <option value="{{ $key }}"  >{{ $value }}</option>
        @endforeach

    </select>
</div>
