@props([
'addinstrument',
'choralinstrumentation',
'classofs',
'displayform',
'footinches',
'geostates',
'guardians',
'heights',
'instrumentalinstrumentation',
'instrumentationbranch_id',
'instrumentationbranches',
'newinstrumentations',
'photo',
'pronouns',
'shirtsizes',
'student' => false,
])

<div
    class="{{$displayform ? 'w-8/12 -ml-4 bg-blue-50 text-black border border border-black border-l-3 border-t-0 border-r-0' : 'hidden'}}">

    @if($student)
        <div>
            {{-- SECTION I  --}}
            <div class="md:grid md:grid-cols-3 md:gap-6 ">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Biography</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Basic biographical information about <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <x-buttons.button-delete id="photo" />
                    <form wire:submit.prevent="biography">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                {{--  SYS.ID --}}
                                <div class="grid grid-cols-3 gap-6">
                                    Sys.Id. {{$student->user_id}}
                                </div>

                                {{-- USERNAME --}}
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <x-inputs.text label="Username" for="username"/>
                                    </div>
                                </div>

                                {{-- PHOTO --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Photo
                                    </label>
                                    <div class="mt-1 flex items-center">

                                        <div class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            @if($student->person->user->profile_photo_path)
                                                <div>
                                                    <img  class="rounded rounded-2xl h-20 w-20" src="{{ '/storage/'.substr($student->person->user->profile_photo_path,7) }}" />
                                                </div>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                {{-- PHOTO  PREVIEW --}}
                                <div class="flex space-x-3">

                                    <form wire:submit.prevent="savePhoto">

                                        <input type="file" wire:model="photo">

                                        @error('photo')<div class="error text-red-600">{{ $message }}</div> @enderror

                                        @if($photo)
                                            <div>
                                                <label>Photo Preview: </label>
                                                <img  class="rounded rounded-full h-20 w-20" src="{{ $photo->temporaryUrl() }}" />
                                            </div>

                                        @endif

                                    </form>
                                </div>

                                {{-- SAVE --}}
                                <x-saves.save-button-with-message message="Biography information saved!"
                                                                  trigger="saved-biography"/>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECTION II --}}
            <div class="md:grid md:grid-cols-3 md:gap-6 bg-blue-100">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Personal</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Basic identification information about <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="personal">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-yellow-50 space-y-6 sm:p-6">

                                {{-- NAMES --}}
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-2 sm:col-span-2">
                                                <x-inputs.text label="First name" for="first"/>
                                            </div>

                                            <div class="col-span-2 sm:col-span-2">
                                                <x-inputs.text label="Middle name" for="middle"/>
                                            </div>

                                            <div class="col-span-2 sm:col-span-2">
                                                <x-inputs.text label="Last name" for="last"/>
                                            </div>

                                            {{-- CLASSOFS --}}
                                            <div class="col-span-6 sm:col-span-4">
                                                <x-inputs.select :options="$classofs"
                                                                 label="Grade/Class of" for="classof"
                                                                 name="classof"
                                                                 id="classof"/>
                                            </div>

                                            {{-- PRONOUN --}}
                                            <div class="col-span-6 sm:col-span-4">
                                                <x-inputs.select :options="$pronouns"
                                                                 label="preferred pronoun" for="pronoun_id"
                                                                 name="pronoun_id"
                                                                 id="pronoun_id"/>
                                            </div>

                                            {{-- HEIGHT --}}
                                            <div class="col-span-6 sm:col-span-4">
                                                <x-inputs.select :options="$heights" label="Height in inches"
                                                                 for="height" name="height" id="height"/>
                                            </div>

                                            {{-- SHIRTSIZE --}}
                                            <div class="col-span-6 sm:col-span-4">
                                                <x-inputs.select :options="$shirtsizes"
                                                                 label="shirt size" for="shirtsize_id"
                                                                 name="shirtsize_id"
                                                                 id="shirtsize_id"/>
                                            </div>

                                            {{-- BIRTHDAY --}}
                                            <div class="col-span-6 sm:col-span-4">
                                                <x-inputs.date wire:select.defer="birthday" label="birthday"
                                                               for="birthday"
                                                               name="birthday" id="birthday"/>
                                            </div>

                                        </div>

                                        {{-- SAVE --}}
                                        <x-saves.save-button-with-message message="Personal information saved!"
                                                                          trigger="saved-personal"/>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECTION III --}}
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Instrumentation</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Voice parts and instruments for <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="instrumentations">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="shadow overflow-hidden sm:rounded-md">
                                    {{-- INSTRUMENTATIONS: CHORAL TABLE --}}
                                    <div>
                                        <table class="ml-6 mt-4 w-10/12">
                                            @if($choralinstrumentation->count())
                                                <thead>
                                                    <tr class="border border-black bg-gray-100 ">
                                                        <th class="pl-2 text-left w-10/12">Voice Part{{ ($choralinstrumentation->count() > 1) ? 's' : '' }}</th>
                                                        <td class="w-2/12">
                                                            <a
                                                                class="text-green-500 text-sm" wire:click.prevent="createInstrumentation"
                                                                href="#">
                                                                Add
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($choralinstrumentation AS $instrument)
                                                        <tr class="border border-black">
                                                            <td class="pl-3 w-10/12">{{ strtoupper($instrument->descr) }}</td>
                                                            <td class="w-2/12">
                                                                <a
                                                                    class="text-red-700 text-sm" wire:click="deleteInstrumentation({{ $instrument->id }})"
                                                                    href="#">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif

                                        </table>
                                    </div>

                                    {{-- INSTRUMENTATIONS: INSTRUMENTAL TABLE --}}
                                    <div>
                                        <table class="ml-6 mt-4 mb-4 w-10/12">
                                            @if($instrumentalinstrumentation->count())
                                                <thead>
                                                    <tr class="border border-black bg-gray-100 ">
                                                        <th class="pl-2 text-left w-10/12">Voice Part{{ ($choralinstrumentation->count() > 1) ? 's' : '' }}</th>
                                                        <td class="w-2/12">
                                                            <a
                                                                class="text-green-500 text-sm" wire:click.prevent="createInstrumentation"
                                                                href="#">
                                                                Add
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($instrumentalinstrumentation AS $instrument)
                                                    <tr class="border border-black">
                                                        <td class="w-10/12">{{ strtoupper($instrument->descr) }}</td>
                                                        <td class="w-2/12">
                                                            <a
                                                                class="text-red-700 text-sm" wire:click="deleteInstrumentation({{ $instrument->id }})"
                                                                href="#">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @endif

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </form>
               </div>
            </div>

            {{-- SECTION IV --}}
            <div class="md:grid md:grid-cols-3 md:gap-6 bg-blue-100">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Contacts</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Email and phone contact information for <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="contacts">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-yellow-50 space-y-6 sm:p-6">

                                {{-- EMAILS --}}
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    {{-- EMAILS:SCHOOL --}}
                                    <div class="px-4 pt-5 sm:p-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.email label="school email" for="emailschool"/>
                                        </div>
                                    </div>
                                    {{-- EMAILS: PERSONAL --}}
                                    <div class="px-4 sm:p-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.email label="personal email" for="emailpersonal"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- PHONES --}}
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    {{-- PHONES:MOBILE --}}
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="cell phone" for="phonemobile"/>
                                        </div>
                                    </div>
                                    {{-- PHONES:HOME --}}
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="home phone" for="phonehome"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- SAVE --}}
                                <x-saves.save-button-with-message message="Contact information saved!"
                                                                  trigger="saved-contacts"/>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECTION V --}}
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Home Address</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Home address for <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="homeAddress">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                {{-- ADDRESS --}}
                                <div class="shadow overflow-hidden sm:rounded-md">

                                    <div class="px-4 pt-5 sm:p-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="Address" for="address01"/>
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="" for="address02"/>
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="City" for="city"/>
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.select label="state" for="geostate_id" :options="$geostates" />
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <x-inputs.text label="zip code" for="postalcode"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- SAVE --}}
                                <x-saves.save-button-with-message message="Home address saved!"
                                                                  trigger="saved-homeaddress"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECTION VI --}}
            <div class="md:grid md:grid-cols-3 md:gap-6 bg-blue-100">
                <div class="md:col-span-1 px-2 py-2">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Parents/Guardians</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Parent/Guardian contact information for <b>{{ $student->person->fullName }}</b>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form wire:submit.prevent="guardians">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-yellow-50 space-y-6 sm:p-6">

                                {{-- GUARDIANS TABLE --}}
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div>
                                        <table class="ml-6 mt-4 mb-3 w-10/12">
                                            <thead>
                                            <tr class="border border-black bg-gray-100 ">
                                                <th class="pl-2 text-left w-10/12">Parent/Guardian{{ ($student->guardians()->count() > 1) ? 's' : '' }}</th>
                                                <td class="w-2/12">
                                                    <a
                                                        class="text-green-500 text-sm" wire:click.prevent="createGuardian"
                                                        href="#">
                                                        Add
                                                    </a>
                                                </td>
                                            </tr>

                                                @forelse($student->guardians AS $guardian)
                                                    <tr class="border border-black bg-white">
                                                        <td class="pl-2 text-left w-10/12">{{ $guardian->person->fullName }} ({{ $guardian->guardiantype()->descr }})</td>
                                                        <td class="w-2/12">
                                                            <a
                                                                class="text-blue-500 text-sm" wire:click.prevent="editGuardian({{ $guardian->user_id }})"
                                                                href="#">
                                                                Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">No parent/guardian found
                                                        </td>
                                                    </tr>
                                                @endforelse

                                        </table>

                                        {{-- SAVED message --}}
                                        <div class="font-italic bg-green-200 p-2"
                                             x-data="{show: false}"
                                             x-show.transition.duration.500ms="show"
                                             x-init="@this.on('saved-guardian',() => {
                                                setTimeout(() => { show = false; }, 2500 );
                                                show = true;
                                            })"
                                        >
                                            Parent/Guardian saved!
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
    @endif
</div>
