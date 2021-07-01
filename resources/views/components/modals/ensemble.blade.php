@props([
'ensemble',
'ensembletypes' => [],
'years' => [],
])
<div>
    <x-modals.confirmation wire:model="showeditmodal">

        <x-slot name="title">Edit {{ $ensemble->name }}</x-slot>

        <x-slot name="content">

            <form wire:submit.prevent="save">
                <x-inputs.group label="Name" for="name" >
                    <x-inputs.text label="" for="name" placeholder="Ensemble name..."/>
                </x-inputs.group>

                <x-inputs.group label="Abbreviation" for="abbr">
                    <x-inputs.text label="" for="abbr" placeholder=""/>
                </x-inputs.group>

                <x-inputs.group label="Type" for="ensembletype_id">
                    <x-inputs.select label="" :options="$ensembletypes" for="ensembletype_id"
                                     currentvalue="{{ $ensemble->ensembletype_id }}"/>
                </x-inputs.group>

                <x-inputs.group label="Start year" for="startyear">
                    <x-inputs.select label="" :options="$years" for="startyear"
                                     currentvalue="{{ $ensemble->startyear }}"/>
                </x-inputs.group>

                <x-inputs.group label="Description" for="descr">
                    <textarea wire:model="descr" cols="30" rows="5" >{{ $ensemble->descr }}</textarea>

                </x-inputs.group>


                <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">
                    <x-saves.save-message-without-button message="Ensemble updated" trigger="ensemble-saved"/>
                    <x-buttons.button wire:click="save" type="submit">Update {{ ucwords($ensemble->name) }}</x-buttons.button>
                </footer>
            </form>

        </x-slot>

        <x-slot name="footer" >
            <x-buttons.secondary wire:click="$toggle('showeditmodal', false)">Cancel</x-buttons.secondary>
        </x-slot>

    </x-modals.confirmation>
</div>
