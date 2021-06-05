<div>
    <x-table-with-modal-form >

        <x-slot name="title">
            {{ __('School and Studio Information') }}
        </x-slot>

        <x-slot name="description" >

            {{ __('Add or edit your school and studio information here.') }}

            <br />
            {{ __('Note that a Studio has been created for you to store information which may be related to your
                    personal studio and independent of any particular school.') }}

        </x-slot>

        <x-slot name="table">
            {{-- Studio + Schools table --}}
            {{-- ADD button --}}
            <div class="flex justify-end pr-6">
                <x-buttons.button-add toggle="showAddModal" />
            </div>

            {{-- beginning of tailwindui table --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 divide-y">
                            <thead class="bg-gray-50">
                                <tr >
                                    @foreach($table_headers AS $header)
                                        <th scope="col" style="width: 25%;" class="@if(($header === 'Location') || ($header === 'Years')) hidden lg:table-cell @endif px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($this->table_schools AS $school)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top">
                                            {{ $school->name }}
                                        </td>
                                        <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-text-top">
                                            {!!  $school->mailingAddress !!}
                                        </td>
                                        <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-text-top">
                                            {{ auth()->user()->person->teacher->tenureYearsAtSchool($school->id) }} {{-- $school->years --}}
                                        </td>
                                        <td class="px-6 py-4 space-x-1 whitespace-nowrap text-center text-sm font-medium flex flex-row justify-around align-text-top">
                                            <a href="#"
                                               wire:click.defer="edit({{ $school->id }})"
                                               class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600">Edit
                                            </a>
                                            <x-buttons.button-delete id="{{ $school->id }}" />

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <x-modals.dialog wire:model="showEditModal" >

                <x-slot name="title">Schools</x-slot>

                <x-slot name="content">
                    {{-- LOCATION --}}
                    <div class="section_descr text-sm bg-gray-200 mb-2 p-2 border border-gray-400 rounded">
                        <p>
                            TheDirectorsRoom.com uses school location information for ALL teachers at this
                            school. <br />
                            Please only update generic school location information and do NOT include
                            location information which is specific to your location (ex. room number) at the school.
                        </p>
                    </div>
                    <x-inputs.text wire:model.defer="name" label="School name" for="name" name="name" id="name" />
                    <x-inputs.text wire:model.defer="address0" label="address" for="address0" name="address0" id="address0" />
                    <x-inputs.text wire:model.defer="address1" label="" for="address1" name="address1" id="address1" />
                    <x-inputs.text wire:model.defer="city" label="city" for="city" name="city" id="city" />
                    <x-inputs.select wire:select.defer="geostate_id" :options="$options" label="state" for="geostate_id" name="geostate_id" id="geostate_id" />
                    <x-inputs.text wire:model.defer="postalcode" label="postalcode" for="postalcode" name="postalcode" id="postalcode" />

                    {{-- TENURE: START/END YEARS --}}
                    <section class="mt-4">
                        <div class="section_descr text-sm bg-gray-200 mb-2 p-2 border border-gray-400 rounded">
                            <p>
                                Please describe your tenure at {{ $name }}. <br />
                                Leave 'End Year' blank if still working there.
                            </p>
                        </div>
                        <x-inputs.select wire:select.defer="startyear" :options="$startyears" label="start year" for="startyear" name="startyear" id="startyear" />
                        <x-inputs.select wire:select.defer="endyear" :options="$endyears" label="end year" for="endyear" name="endyear" id="endyear" />
                    </section>

                    {{-- GRADES --}}
                    <section class="mt-4">
                        <div class="section_descr text-sm bg-gray-200 mb-2 p-2 border border-gray-400 rounded">
                            <p>
                                Please select the grades you teach at {{ $name }}.
                            </p>
                        </div>
                        <div class="section_values flex flex-wrap ">
                            @foreach($gradetypes AS $key => $value)
                                <div class="ml-2">
                                    <label>{{ $value }}</label>
                                    <input type="checkbox"
                                           wire:click="updateGrades({{ $key }})"
                                           name="grades[{{ $key }}]"
                                           id="grades[{{ $key }}]"
                                           @if($grades[$key]) CHECKED @endif
                                           value="1"
                                    />
                                </div>
                            @endforeach
                            <!-- {{-- <x-inputs.checkbox selected="1" label="grade 1" for="grades[1]" name="grades[1]" id="grades[1]" /> --}} -->
                        </div>
                    </section>

                </x-slot>

                <x-slot name="footer">
                    <x-buttons.secondary wire:click="$set('showEditModal',false)" >Cancel</x-buttons.secondary>
                    <x-buttons.button wire:click="save" >Save</x-buttons.button>
                </x-slot>
            </x-modals.dialog>

            <!-- Add Modal -->
            <x-modals.dialog wire:model="showAddModal" >

                <x-slot name="title">Add a School</x-slot>

                <x-slot name="content">
                    {{-- LOCATION --}}
                    @if($schoolid)
                        <div>
                            <div class="font-bold">{{ $name }} </div>
                            <div>{!! $mailingaddress !!}</div>
                        </div>
                    @else
                        <x-inputs.text wire:model="name" label="School name" for="name" name="name" id="name" required="required" />
                        <div>
                            @if(count($searchresults))
                                <ul class="m-3 text-sm">
                                    @foreach($searchresults AS $key => $value)
                                        <li>
                                            <div wire:click='loadSchool({{ $key }})' class="cursor-pointer">
                                                {{ $value }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <x-inputs.text wire:model.defer="address01" label="address" for="address01" name="address01" id="address01" />
                        <x-inputs.text wire:model.defer="address02" label="" for="address02" name="address02" id="address02" />
                        <x-inputs.text wire:model.defer="city" label="city" for="city" name="city" id="city" />
                        <x-inputs.select wire:select.defer="geostate_id" :options="$options" label="state" for="geostate_id" name="geostate_id" id="geostate_id" />
                        <x-inputs.text wire:model.defer="postalcode" label="postalcode" for="postalcode" name="postalcode" id="postalcode" />
                    @endif

                    {{-- TENURE: START/END YEARS --}}
                    <section class="mt-4">
                        <div class="section_descr text-sm bg-gray-200 mb-2 p-2 border border-gray-400 rounded">
                            <p>
                                Please describe your tenure at {{ $name }}. <br />
                                Leave 'End Year' blank if still working there.
                            </p>
                        </div>
                        <x-inputs.select wire:select.defer="startyear" :options="$startyears" label="start year" for="startyear" name="startyear" id="startyear" />
                        <x-inputs.select wire:select.defer="endyear" :options="$endyears" label="end year" for="endyear" name="endyear" id="endyear" />
                    </section>

                    {{-- GRADES --}}
                    <section class="mt-4 space-y-2">
                        <div class="section_descr text-sm bg-gray-200 p-2 border border-gray-400 rounded">
                            <p>
                                Please select the grades you teach at {{ $name }}.
                            </p>
                        </div>
                        <div class="section_values flex flex-wrap">
                            @foreach($gradetypes AS $key => $value)
                                <div class="ml-2">
                                    <label>{{ $value }}</label>
                                    <input type="checkbox"
                                           wire:click="updateGrades({{ $key }})"
                                           name="grades[{{ $key }}]"
                                           id="grades[{{ $key }}]"
                                           @if($grades[$key]) CHECKED @endif
                                           value="1"
                                    />
                                </div>
                            @endforeach

                        </div>

                        @if(! $grades_found)
                            <div class="section_advisory text-sm text-red-900 bg-red-100 mb-2 p-2 border border-red-400 rounded ">
                                Grades enable significant student, organization, and event functionality. You are strongly
                                encouraged to check at least one grade.
                            </div>
                        @endif
                    </section>

                </x-slot>

                <x-slot name="footer">
                    <x-buttons.secondary wire:click="cancelAdd" >Cancel</x-buttons.secondary>
                    <x-buttons.button wire:click="add" >Add New School</x-buttons.button>
                </x-slot>
            </x-modals.dialog>

        </x-slot>

        <x-slot name="actions">


        </x-slot>

    </x-table-with-modal-form>
</div>
