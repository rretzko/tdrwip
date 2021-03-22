<div>
    <x-table-with-modal-form >

        <x-slot name="title">
            {{ __('School and Studio Information') }}
        </x-slot>

        <x-slot name="description" >

            {{ __('Add or edit your school information here.') }}

            <br />
            {{ __('Note also that a Studio has been created for you to store information which may not be aligned to any
                    particular school or may be related to your personal studio.') }}

        </x-slot>

        <x-slot name="table">
            <!-- Studio + Schools table -->
            <!-- beginning of tailwindui table -->
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 "> <!--  -->
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach($table_headers AS $header)
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $header }}
                                            </th>
                                    @endforeach
                            </thead>
                            <tbody>

                                @foreach($this->table_studios AS $studio)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $studio->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {!!  $studio->mailingAddress !!}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ $studio->years }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex flex-row justify-around">
                                            <a href="#"
                                               wire:click.defer="edit(false,{{ $studio->id }})"
                                               class="border border-blue-500 rounded px-2 bg-blue-400 text-white">Edit
                                            </a>
                                            <x-buttons.button-delete />


                                        </td>
                                    </tr>
                                @endforeach

                                @forelse($this->table_schools AS $school)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $school->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                              $school->mailingAddress
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                             $school->years
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium ">
                                            <x-jet-button wire:click="toggleModal({{ $school->id }})">
                                                {{ __('Edit') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-gray-200">
                                        <td colspan="4" class="text-center">No schools found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <x-modals.dialog wire:model="showEditModal" >

                <x-slot name="title">{{ $entity_type }}</x-slot>

                <x-slot name="content">
                    {{-- LOCATION --}}
                    <x-inputs.text wire:model="name" label="{{ strtolower($entity_type) }} name" for="name" name="name" id="name" />
                    <x-inputs.text wire:model="address01" label="address" for="address01" name="address01" id="address01" />
                    <x-inputs.text wire:model="address02" label="" for="address02" name="address02" id="address02" />
                    <x-inputs.text wire:model="city" label="city" for="city" name="city" id="city" />
                    <x-inputs.select wire:select="geostate_id" :options="$options" selected="{{ $geostate_id }}" label="state" for="geostate_id" name="geostate_id" id="geostate_id" />
                    <x-inputs.text wire:model="postalcode" label="postalcode" for="postalcode" name="postalcode" id="postalcode" />

                    {{-- START/END YEARS --}}
                    <section class="mt-4">
                        <div class="section_descr text-sm bg-gray-200 p-2 border border-gray-400 rounded">
                            <p>
                                Please describe your tenure at {{ $name }}. <br />
                                Leave 'End Year' blank if still working there.
                            </p>
                        </div>
                        <x-inputs.select wire:select="startyear" :options="$startyears" selected="{{ $startyear }}" label="start year" for="startyear" name="startyear" id="startyear" />
                        <x-inputs.select wire:select="endyear" :options="$endyears" selected="{{ $endyear }}" label="end year" for="endyear" name="endyear" id="endyear" />
                    </section>

                </x-slot>

                <x-slot name="footer">
                    <x-buttons.secondary>Cancel</x-buttons.secondary>
                    <x-buttons.button wire:click="save" >Save</x-buttons.button>
                </x-slot>
            </x-modals.dialog>

        </x-slot>

        <x-slot name="actions">


        </x-slot>

    </x-table-with-modal-form>
</div>
