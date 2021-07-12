@props([
'ensemble',
'member',
])
<div class="mt-4">

        <h4 class="font-bold text-lg">{{ $ensemble->name }} assets for: {{ $member->person->fullName }}.</h4>

        <x-tables.surgetable>
            <x-slot name="head">
                <x-tables.heading >Name</x-tables.heading>
                <x-tables.heading >Description</x-tables.heading>
                <x-tables.heading class="sr-only">Update</x-tables.heading>
            </x-slot>

            <x-slot name="body">

                @if($ensemble->assets->count())

                    @foreach($ensemble->assets AS $asset)

                        <x-tables.row altcolor="{{ $loop->odd }}">

                            <form wire:submit.prevent="saveAsset" name="asset_{{ $asset->id }}">
                                <input type="hidden" name="asset_id" value="{{ $asset->id }}" />

                                <x-tables.cell>
                                    {{ ucwords($asset->descr) }}
                                </x-tables.cell>

                                <x-tables.cell>
                                    <input type="text" name="descr" value="" placeholder="ex. number, size, or text" />
                                </x-tables.cell>

                                <x-tables.cell>
                                    <x-saves.save-message-without-button message="Asset {{ ($asset->id) ? 'updated' : 'added' }}" trigger="asset-saved" key="{{ $asset->id }}"/>
                                    <x-buttons.button wire:click="saveAsset" type="submit">@if($asset->id) Update @else Add  @endif</x-buttons.button>
                                </x-tables.cell>

                            </form>

                        </x-tables.row>

                    @endforeach

                @else

                    <x-tables.row >
                        <x-tables.cell colspan="3" class="text-center text-lg text-gray-900">
                            No ensemble assets found for {{ $ensemble->name }}
                        </x-tables.cell>
                    </x-tables.row>

                @endif
            </x-slot>
        </x-tables.surgetable>

        <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">

        </footer>

</div>
