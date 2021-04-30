@props([
'student',
'photo',
])

<div class="md:grid md:grid-cols-3 md:gap-6 mt-3">
    <div class="md:col-span-1 px-2 py-2">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Biography</h3>
            <p class="mt-1 text-sm text-gray-600">
                Basic biographical information about: <br /><b>{{ $student->person->fullName }}</b>
            </p>
        </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2">
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
                            <div class=" text-xs text-red-800 mt-1 px-2">If you change {{ $student->person->first }}'s username, make sure you tell {{ $student->person->pronoun->object }}.</div>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-12" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- PHOTO --}}
                    <div class="flex space-x-3">

                        <!-- <form wire:submit.prevent="savePhoto"> -->

                            <div class="flex-col">
                                <input type="file" wire:model="photo">

                                @error('photo')<div class="error text-red-600">{{ $message }}</div> @enderror

                                @if($photo)
                                    {{-- PHOTO  PREVIEW --}}
                                    <div>
                                        <label>Photo Preview: </label>
                                        <img  class="rounded rounded-full h-20 w-20" src="{{ $photo->temporaryUrl() }}" />
                                    </div>

                                @endif
                            </div>

                        <!-- </form> -->
                    </div>

                    {{-- SAVE --}}
                    <x-saves.save-button-with-message message="Biography information saved!"
                                                      trigger="saved-biography"/>

                </div>
            </div>
        </form>
    </div>
</div>
