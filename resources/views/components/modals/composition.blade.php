@props([
'composition',
'geostates',
'publisherslist',
'showpublisherform',
])
<>
    <x-modals.confirmation wire:model="showeditmodal">

        <x-slot name="title">@if($composition->id) Edit {{ $composition->title }} @else Add a New Composition @endif</x-slot>

        <x-slot name="content">

            <form wire:submit.prevent="save">
                <x-inputs.group x-data x-init="$refs.title.focus()" label="Title" for="title" >
                    <x-inputs.text label="" x-ref="title" for="title" placeholder="Composition title..."  />
                </x-inputs.group>

                <x-inputs.group   label="Publisher" for="publisher_id">

                    <div class="flex sm:flex-col">

                        <x-inputs.text
                            label=""
                            for="publishername"
                        />

                        @if($showpublisherform) {{-- Display publisher form for adding a new publisher --}}
                            <div class="ml-4">
                                <x-inputs.text
                                    model:wire.lazy="publisheraddress0"
                                    class="text-xs"
                                    label=""
                                    for="publisheraddress0"
                                    placeholder="address 1..."
                                />

                                <x-inputs.text
                                    model:wire.lazy="publisheraddress1"
                                    label=""
                                    for="publisheraddress1"
                                    placeholder="address 2..."
                                />

                                <x-inputs.text
                                    model:wire.lazy="publishercity"
                                    label=""
                                    for="publishercity"
                                    placeholder="city..."
                                />

                                 <x-inputs.select
                                    model:wire.lazy="publishergeostateid"
                                    label="State"
                                    for="publishergeostateid"
                                    :options="$geostates"
                                />

                                <x-inputs.text
                                    model:wire.lazy="publisherpostalcode"
                                    label=""
                                    for="publisherpostalcode"
                                    placeholder="zip code..."
                                />

                                <div class="flex justify-end">

                                    <x-buttons.button-link wire:click="savepublisher" class="bg-green-200 border-green-800 rounded text-black p-2 hover:bg-green-300">
                                        Add Publisher
                                    </x-buttons.button-link>

                                </div>
                            </div>

                        @else {{-- Display list of publishers --}}
                            @forelse($publisherslist AS $key => $publishername)
                                <div class="ml-4">
                                    <a  class="text-gray-900 text-xs"
                                        href="{{ $key }}">
                                        {{ $publishername }}
                                    </a>
                                </div>
                            @empty
                                <div class="text-gray-400 text-center text-lg">No publishers found</div>
                            @endforelse
                        @endif

                    </div>

                </x-inputs.group>

                <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">
                    <x-saves.save-message-without-button message="Composition {{ ($composition->id) ? 'updated' : 'added' }}" trigger="composition-saved"/>
                    <x-buttons.button wire:click="save" type="submit">@if($composition->id) Update {{ ucwords($composition->name) }} @else Add New Composition @endif</x-buttons.button>
                </footer>
            </form>

        </x-slot>

        <x-slot name="footer" >
            <x-buttons.secondary wire:click="$toggle('showeditmodal', false)">Cancel</x-buttons.secondary>
        </x-slot>

    </x-modals.confirmation>
</div>
