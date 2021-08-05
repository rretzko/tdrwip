<div>
    Profile for: {{ $student->person->fullName }}

    <form wire:submit.prevent="save">
        <x-inputs.group label="Name" for="first" class="flex">
            <x-inputs.text label="" for="first" placeholder="First name..."/>
            <x-inputs.text label="" for="middle" placeholder=""/>
            <x-inputs.text label="" for="last" placeholder="Last name..."/>
        </x-inputs.group>

        <x-inputs.group label="Grade/Class of" for="classof">
            <x-inputs.select label="" :options="$classofs" for="classof" currentvalue="{{ $student->classof }}"/>
        </x-inputs.group>

        <x-inputs.group label="Preferred Pronoun" for="pronoun_id">
            <x-inputs.select label="" :options="$pronouns" for="pronoun_id"
                             currentvalue="{{ $student->person->pronoun_id }}"/>
        </x-inputs.group>

        <x-inputs.group label="Height in inches" for="height">
            <x-inputs.select label="" :options="$heights" for="height" currentvalue="{{ $student->height }}"/>
        </x-inputs.group>

        <x-inputs.group label="Shirt size" for="shirtsize">
            <x-inputs.select label="" :options="$shirtsizes" for="shirtsize_id"
                             currentvalue="{{ $student->shirtsize_id }}"/>
        </x-inputs.group>

        <x-inputs.group label="Birthday" for="birthday">
            <x-inputs.date label="" for="birthday"/>
        </x-inputs.group>

        <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">
            <x-saves.save-message-without-button message="Profile updated" trigger="profile-saved"/>
            <x-buttons.button wire:click="save" type="submit">Update {{ ucwords($student->person->fullname) }}</x-buttons.button>
        </footer>
    </form>
</div>