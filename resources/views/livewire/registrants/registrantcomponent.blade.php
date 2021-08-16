<div>
    <div>
        <x-livewire-table-with-modal-forms>

            <x-slot name="title">
                {{ __('Registrant Information') }}
            </x-slot>

            <x-slot name="description">

                <x-sidebar-blurb blurb="Add or edit your registrant information here."/>

                <x-sidebar-blurb blurb="Registrants have three status types: Eligible, Applied, Registered, and
                    Hidden." />

                <x-sidebar-blurb blurb="Click the 'Eligible' column header to toggle the roster for each status type." />

            </x-slot>

            <x-slot name="table">
                {{-- Events table --}}
                {{-- Per Page and Bulk actions are commented out but left for future usage --}}
                <div class="flex justify-end pr-6 space-x-2">
                    <x-inputs.dropdowns.perpage />
                    <!-- {{-- <x-inputs.dropdowns.bulkactions :selected="$selected" /> --}} -->

                    <x-buttons.button-add toggle="showaddmodal"/>
                </div>

                {{-- HEADER --}}
                <div class="text-center font-bold text-xl mb-2">
                    {{ $event->name }}  Registration Status Roster
                </div>

                {{-- beginning of tailwindui table --}}

                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                    <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                        <div class="space-y-4 overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        {{-- SEARCH --}}
                         <div class="flex space-x-4 justify-between">
                             <div class="flex">
                                <x-inputs.text wire:model.debounce.1s="search"
                                   for="search"
                                   label=""
                                   placeholder="Search last name..."/>
                            </div>

                             <div class="">
                                 <a href="{{ route('pitchfiles',['eventversion' => $event]) }}" title="Pitch Files" class="text-blue-600">
                                 {{-- SIXTEENTH NOTES --}}
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                         <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                     </svg>
                                 </a>
                             </div>
 <!-- {{--
                            <div class="flex text-sm text-gray-600">
                                <x-buttons.button-link wire:click="$toggle('showfilters')">
                                    @if($showfilters) Hide @endif Advanced Filters @if(strlen($filterstring)) (current: "{{ $filterstring }}") @endif
                                </x-buttons.button-link>
                            </div>
 --}} -->
                        </div>
<!-- {{--
                           <div>
                                @if($showfilters)
                                    <div class="bg-gray-300 p-4 rounded shadow-inner flex relative">

                                        <div class="2-1/2 pr-2 space-y-4">
                                            <div class=" border border-black p-2 bg-gray-200 text-sm" id="advisory">
                                                Please note: Filters are applied against the selected population
                                                (Current/Alum/All) and will temporarily remove pagination.
                                            </div>

                                            <x-inputs.group inline for="filter-first" label="First Name">

                                                <x-inputs.text id="filter-first" for="filters.first" label="" placeholder="Seach by first name..."/>
                                            </x-inputs.group>

                                            <x-inputs.group inline for="filter-instrumentations" label="Voice Parts">
                                                <x-inputs.select id="filter-instrumentations"
                                                                 for="filters.instrumentation_id"
                                                                 label=""
                                                                 :options="$sortedinstrumentations"
                                                                 placeholder="Select Voice Part..."
                                                                 immediate
                                                >

                                                </x-inputs.select>
                                            </x-inputs.group>

                                            <x-inputs.group inline for="filter-classofs" label="Classes">
                                                <x-inputs.select id="filter-classofs"
                                                                 for="filters.classof" label=""
                                                                 :options="$sortedclassofs"
                                                                 placeholder="Select Class..."
                                                                 immediate
                                                >

                                                </x-inputs.select>
                                            </x-inputs.group>

                                            <x-buttons.button-link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-buttons.button-link>
                                        </div>

                                    </div>
                                @endif
                            </div>
--}} -->

                            <x-tables.surgetable class="w-full">
                                <x-slot name="head">

                                    <th class="px-2" >###</th>
                                    <th class="px-2" title="Student name">Name</th>
                                    <th class="px-2" title="Open">Grade</th>
                                    <th class="px-2" title="Event voice part">Voice</th>
                                    <th class="px-2" title="Signature Confirmation">Sig</th>
                                    <th class="px-2 cursor-pointer text-blue-700" title="Status"
                                            wire:click='status'>
                                        {{ ucwords($population) }}
                                    </th>
                                    <th class="sr-only">Edit</th>

                                </x-slot>

                                <x-slot name="body">

                                {{-- Commented out and left for future usage --}}
                                <!-- {{--
                                    @if($selectpage)

                                        <x-tables.row class="bg-gray-200" wire:key="row-message">
                                            <x-tables.cell colspan="8">
                                                @unless($selectall)
                                                    <div>You have selected <strong>{{ count($selected) }}</strong> organizations, do
                                                        you want to select all <strong>{{ $organizations->count() }}</strong>?
                                                        <x-buttons.button-link wire:click="selectAll"
                                                                               class="ml-1 text-blue-600">Select All
                                                        </x-buttons.button-link>
                                                    </div>
                                                @else
                                                    <span>You have selected all <strong>{{ $organizations->count() }}</strong>
                                                    organizations.</span>
                                                @endunless
                                            </x-tables.cell>
                                        </x-tables.row>
                                    @endif
                                    --}} -->

                                    @forelse($registrants AS $registrant)
                                        <x-tables.row
                                            wire:loading.class.delay="opacity-50"
                                            style=""
                                            wire:key="row-{{ $registrant->user_id }}"
                                            altcolor="{{$loop->even}}"
                                        >
                                            <x-tables.cell>
                                                {{ $loop->iteration }}
                                            </x-tables.cell>
                                            <x-tables.cell>
                                                {{ $registrant['student']['person']->fullNameAlpha }}
                                            </x-tables.cell>

                                            <x-tables.cell>
                                                {{ $registrant['student']->grade }}
                                            </x-tables.cell>

                                            <x-tables.cell class="text-center uppercase">
                                                {{ $registrant->instrumentationsCSV }}
                                            </x-tables.cell>

                                            <x-tables.cell>
                                                chkbx
                                            </x-tables.cell>

                                            <x-tables.cell>
                                                {{ ucwords($registrant->registranttype->descr) }}
                                            </x-tables.cell>

                                            <x-tables.cell>
                                                <x-buttons.button-link
                                                    class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                                >
                                                    <a href="{{ route('registrant.show',['registrant' => $registrant]) }}">
                                                        Edit
                                                    </a>
                                                </x-buttons.button-link>
                                            </x-tables.cell>
                                        </x-tables.row>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-gray-500 text-center">
                                                No Events found @if(strlen($this->search)) with search
                                                value: {{ $this->search }}@endif.
                                            </td>
                                        </tr>

                                @endforelse
                                {{-- PAGINATION TOP LINKS --}}
                                <div class="mb-2">
                                    {{$registrants->count() ? $registrants->links() : ''}}
                                </div>

                                </x-slot>

                            </x-tables.surgetable>

                        {{-- PAGINATION BOTTOM LINKS --}}
                        <div class="mb-2">
                            @if($registrants->count() > 5)
                                {{$registrants->count() ? $registrants->links() : ''}}
                            @endif

                        </div>

                        </div>
                    </div>
                </div>

                {{-- MODALS --}}
                {{-- ADD/EDIT EVENT --}}
                <div>
                    @if($showeditmodal)
                        {{-- <x-modals.membership
                            request="true"
                            membershipid="{{$editorganizationmembershipid}}"
                            :organization="$editorganization"
                            :membershiptypes="$membershiptypes"
                        /> --}}
                    @endif
                </div>

                {{-- DELETE ENSEMBLE --}}
                <div>
                @if($showDeleteModal)
                    <!-- {{-- <x-modals.delete :selected="$selected" objectname="ensemble" /> --}} -->
                    @endif
                </div>

            </x-slot>

            <x-slot name="actions">

            </x-slot>

        </x-livewire-table-with-modal-forms>
    </div>

</div>



