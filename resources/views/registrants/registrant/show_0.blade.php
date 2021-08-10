<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-red-50">

            <div class="flex text-red-700 -mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <a href="{{ route('registrants.index',['eventversion' => $eventversion]) }}" class="text-red-700 ml-2 pb-4">
                    Return to Registrant Roster
                </a>
            </div>

            <header class="text-2xl text-center">
                {{ $registrant->student->person->fullName }} registration information for: {{ $eventversion->name }}
            </header>

            <form  class="px-2" method="post" action="{{ route('registrant.update', ['registrant' => $registrant]) }}">
                <x-inputs.group x-data x-init="$refs.programname.focus()" label="Program name" for="programname" >
                    <x-inputs.text label="" x-ref="programname" for="programname" placeholder=""
                        value="{{ $registrant->programname }}"
                    />
                    <span class="hint">Name as it will appear in the program</span>
                </x-inputs.group>
            </form>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
