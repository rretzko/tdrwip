<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div>

                <x-livewire-table-with-modal-forms>

                <x-slot name="title">
                    {{ __('Registrant Information') }}
                </x-slot>

                <x-slot name="description">

                    <x-sidebar-blurb blurb="{{ $registrant->student->person->fullName }} registration information for: {{ $eventversion->name }}"/>

                    <x-sidebar-blurb blurb="Events..." />

                </x-slot>

                <x-slot name="table">

                    {{-- BACK TO ROSTER --}}
                    <div class="flex text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <a href="{{ route('registrants.index',['eventversion' => $eventversion]) }}" class="text-red-700 ml-2 pb-4">
                            Return to Registrant Roster
                        </a>
                    </div>

                    {{-- REGISTRANT FORM --}}
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                        <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                            <div class="space-y-4 overflow-hidden border-b border-gray-200 sm:rounded-lg">

                                <form  class="px-2" method="post" action="{{ route('registrant.update', ['registrant' => $registrant]) }}">

                                    @csrf

                                    {{-- GRADE/CLASS ADVISORY --}}
                                    <x-inputs.group label="Grade/Class" for="" borderless="true" paddingless="true">

                                        <div class="mt-2">
                                            {{ $registrant->student->gradeClassof }}
                                        </div>

                                    </x-inputs.group>

                                    {{-- PRONOUN ADVISORY --}}
                                    <x-inputs.group label="Preferred Pronoun" for="" borderless="true" paddingless="true">

                                        <div class="mt-2">
                                            {{ $registrant->student->person->pronoun->descr }}
                                        </div>

                                    </x-inputs.group>

                                    {{-- PROGRAM NAME --}}
                                    <x-inputs.group x-data x-init="$refs.programname.focus()" label="Program name" for="programname"
                                                    borderless="true" paddingless="true"
                                    >

                                        <x-inputs.text label="" x-ref="programname" for="programname" placeholder=""
                                                       currentvalue="{{ $registrant->programname === 'Programname'
                                                            ? $registrant->student->person->fullName
                                                            : $registrant->programname }}
                                                           "
                                        />
                                        <span class="hint text-xs">Name as it will appear in the program</span>

                                    </x-inputs.group>

                                    {{-- AUDITION VOICING --}}
                                    <x-inputs.group x-data label="Audition part" for="instrumentations[0]"
                                                    borderless="true" paddingless="true">
                                        @for($i=0; $i < $eventversion['eventversionconfigs']->instrumentation_count; $i++)
                                            <select name="instrumentations[]">
                                                @forelse($eventversion->eventensembles->first()->eventensembletype()->instrumentations AS $instrumentation)
                                                    <option value="{{ $instrumentation->id }}"
                                                        @if ($registrant->instrumentations[$i]->id == $instrumentation->id) SELECTED @endif
                                                    >
                                                        {{ $instrumentation->descr }}
                                                    </option>
                                                @empty
                                                    None found
                                                @endforelse
                                            </select>
                                        @endfor

                                    </x-inputs.group>

                                    <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">
                                        <div class="font-italic @if(isset($message)) bg-green-200 @endif px-2"
                                        >
                                            {{ isset($message) ? $message : ''}}
                                        </div>
                                        <x-buttons.button type="submit">Update {{ $registrant->student->person->first }} </x-buttons.button>

                                    </footer>

                                </form>

                            </div>
                        </div>
                    </div>

                </x-slot>

                <x-slot name="actions">

                </x-slot>

            </x-livewire-table-with-modal-forms>
            </div>
        </div>
    </div>

</x-app-layout>

