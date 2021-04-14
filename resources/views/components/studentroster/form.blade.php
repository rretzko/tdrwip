@props([
'displayform',
'footinches',
'heights',
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

                                            {{-- PROUNOUN --}}
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
        </div>
</div>

<!-- {{--
                            <div class="col-span-6 sm:col-span-4">
                                <label for="email_address"
                                       class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <input type="text" name="email_address" id="email_address"
                                       autocomplete="email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country
                                    /
                                    Region</label>
                                <select id="country" name="country" autocomplete="country"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="street_address"
                                       class="block text-sm font-medium text-gray-700">Street
                                    address</label>
                                <input type="text" name="street_address" id="street_address"
                                       autocomplete="street-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city"
                                       class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700">State
                                    /
                                    Province</label>
                                <input type="text" name="state" id="state"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="postal_code"
                                       class="block text-sm font-medium text-gray-700">ZIP /
                                    Postal</label>
                                <input type="text" name="postal_code" id="postal_code"
                                       autocomplete="postal-code"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </div>

        </div>
        </form>
</div>
</div>
</div>

<div class="hidden sm:block" aria-hidden="true">
    <div class="py-5">
        <div class="border-t border-gray-200"></div>
    </div>
</div>

<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Use a permanent address where you can receive mail.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="email_address" class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <input type="text" name="email_address" id="email_address" autocomplete="email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country /
                                    Region</label>
                                <select id="country" name="country" autocomplete="country"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="street_address" class="block text-sm font-medium text-gray-700">Street
                                    address</label>
                                <input type="text" name="street_address" id="street_address"
                                       autocomplete="street-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700">State /
                                    Province</label>
                                <input type="text" name="state" id="state"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">ZIP /
                                    Postal</label>
                                <input type="text" name="postal_code" id="postal_code"
                                       autocomplete="postal-code"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="hidden sm:block" aria-hidden="true">
    <div class="py-5">
        <div class="border-t border-gray-200"></div>
    </div>
</div>

<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Notifications</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Decide which communications you'd like to receive and how.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">By Email</legend>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="comments" name="comments" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="comments" class="font-medium text-gray-700">Comments</label>
                                        <p class="text-gray-500">Get notified when someones posts a comment on a
                                            posting.</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="candidates" name="candidates" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="candidates"
                                               class="font-medium text-gray-700">Candidates</label>
                                        <p class="text-gray-500">Get notified when a candidate applies for a
                                            job.</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="offers" name="offers" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="offers" class="font-medium text-gray-700">Offers</label>
                                        <p class="text-gray-500">Get notified when a candidate accepts or
                                            rejects an offer.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div>
                                <legend class="text-base font-medium text-gray-900">Push Notifications</legend>
                                <p class="text-sm text-gray-500">These are delivered via SMS to your mobile
                                    phone.</p>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="push_everything" name="push_notifications" type="radio"
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="push_everything"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        Everything
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push_email" name="push_notifications" type="radio"
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="push_email"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        Same as email
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push_nothing" name="push_notifications" type="radio"
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="push_nothing"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        No push notifications
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>
