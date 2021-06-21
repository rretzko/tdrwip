@props([
    'objectname',
    'selected' => [],
])
<form wire:model.prevent="deleteSelected" >
    <x-modals.confirmation wire:model="showDeleteModal">

        <x-slot name="title">Delete a {{ ucwords($objectname) }}</x-slot>

        <x-slot name="content">

            @if(count($selected))
                Are you sure you want to delete @if(count($selected) > 1) these {{ $objectname }}s @else this {{ $objectname }} @endif ?
            @else
                No {{ $objectname }}s were selected to be deleted.
            @endif

        </x-slot>

        <x-slot name="footer">
            <x-buttons.secondary wire:click="$toggle('showDeleteModal', false)">Cancel</x-buttons.secondary>
            <x-buttons.button wire:click="deleteSelected" >Delete {{ ucwords($objectname) }}</x-buttons.button>
        </x-slot>

    </x-modals.confirmation>
</form>
