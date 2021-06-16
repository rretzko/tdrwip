@props([
    'selected' => [],
])
<x-inputs.dropdown label="Bulk Actions" key="bulkactions">
    @if(count($selected))
        <x-inputs.dropdownitem type="button" wire:click="exportSelected" class="flex items-center space-x-1">
            <x-icons.download class="text-gray-400" />
            <span>Export</span>
        </x-inputs.dropdownitem>

        <x-inputs.dropdownitem type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-1">
            <x-icons.trash class="text-gray-400" />
            <span>Delete</span>
        </x-inputs.dropdownitem>
    @else
        <x-inputs.dropdownitem class="flex items-center space-x-1 cursor-text">
            <x-icons.download class="text-gray-400" />
            <span class="text-gray-400 ">Export (none selected)</span>
        </x-inputs.dropdownitem>

        <x-inputs.dropdownitem class="flex items-center space-x-1 cursor-text">
            <x-icons.trash class="text-gray-400" />
            <span class="text-gray-400">Delete (none selected)</span>
        </x-inputs.dropdownitem>
    @endif

</x-inputs.dropdown>
