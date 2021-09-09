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

                <x-sidebar-blurb blurb="As students progress from Eligible to Applied and Registered, the 'Registration
                Progress' bar will update to keep you aware of that progress." />

                <x-sidebar-blurb blurb="Click the <a class='text-yellow-100' href='{{ route('pitchfiles',['eventversion' => $event]) }}'>eighth-notes</a> icon to access the pitch files." />

                <x-sidebar-blurb blurb="Students with a status type of 'Registered' will appear on your
                    <a class='text-yellow-100' href='{{ route('registrant.estimateform',['eventversion' => $event]) }}'>Estimate</a> form
                    located between the Search bar and the Pitch Files icon." />

                <x-sidebar-blurb blurb="You may keep a record of your student payments by clicking on the
                    <a class='text-yellow-100' href='{{ route('registrant.payments',['eventversion' => $event]) }}'>'Payments'</a> link
                    located between the Search bar and the Pitch Files icon." />

                <div class="mb-1.5 text-white">{!! $registrantstatus !!}</div>

            </x-slot>

            <x-slot name="table">
                {{-- Events table --}}
                {{-- Per Page and Bulk actions are commented out but left for future usage --}}
                <div class="flex justify-end pr-6 space-x-2">
                    <x-inputs.dropdowns.perpage />
                    <!-- {{-- <x-inputs.dropdowns.bulkactions :selected="$selected" /> --}} -->

                    <!-- {{-- <x-buttons.button-add toggle="showaddmodal"/> --}} -->
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

                             {{-- ESTIMATE FORM --}}
                             <div class="pt-3">
                                 <a href="{{ route('registrant.estimateform',['eventversion' => $event]) }}"
                                    class=" bg-yellow-200 text-blue-700 font-bold border border-blue-700 rounded px-2"
                                    title="{{ $event->name }} estimate form"
                                 >
                                     Estimate
                                 </a>
                             </div>

                             {{-- PAYMENT FORM --}}
                             <div class="pt-3">
                                 <a href="{{ route('registrant.payments',['eventversion' => $event]) }}"
                                    class=" bg-green-200 text-green-800 font-bold border border-green-700 rounded px-2"
                                    title="Student Payments"
                                 >
                                     Payments
                                 </a>
                             </div>

                             {{-- PITCH FILES --}}
                             <div class="">
                                 <a href="{{ route('pitchfiles',['eventversion' => $event]) }}" title="Pitch Files" class="text-blue-600">
                                 {{-- SIXTEENTH NOTES --}}
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                         <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                     </svg>
                                 </a>
                             </div>
                        </div>

                        {{-- STUDENT PAYPAL OPTION --}}
                        <div >
                            @if($event->eventversionconfigs->paypalstudent)
                                <div class="text-white px-1 rounded text-center
                                    @if($event->eventversionteacherconfigs->where('user_id', auth()->id())->first()->paypalstudent)
                                        bg-green-700
                                    @else
                                        bg-blue-700
                                    @endif
                                    ">
                                    @if(config('app.url') === 'http://localhost')

                                            <a href=" {{ route('eventversionteacherconfig.update', ['eventversion' => $event]) }}" >
                                                @if($event->eventversionteacherconfigs->where('user_id', auth()->id())->first()->paypalstudent)
                                                    Currently, my students can pay through PayPal.
                                                @else
                                                    Allow my students to pay via PayPal
                                                @endif
                                            </a>

                                    @else
                                        <a href="https://thedirectorsroom.com/registrants/configs/{{ $event }}">
                                            Allow my students to pay via PayPal
                                        </a>
                                    @endif

                                </div>
                            @endif
                        </div>

                        {{-- REGISTRATION STATE --}}
                        <div>
                            {!! $schoolregistrationstatus !!}
                        </div>

                            <x-tables.surgetable class="w-full">
                                <x-slot name="head">

                                    <th class="px-2" >###</th>
                                    <th class="px-2" title="Student name">Name</th>
                                    <th class="px-2" title="Open">Grade</th>
                                    <th class="px-2" title="Event voice part">Voice</th>
                                    <th class="px-2 cursor-pointer text-blue-700" title="Status"
                                            wire:click='status'>
                                        {{ ucwords($population) }}
                                    </th>
                                    <th class="sr-only">Edit</th>

                                </x-slot>

                                <x-slot name="body">

                                    @forelse($registrants AS $registrant)
                                        @if($registrant && $registrant->user_id)
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

                                                <x-tables.cell >
                                                    <div class="{{ $registrant->registranttypeDescrBackground }} p-1 text-center text-xs border border-gray-400 rounded">
                                                        <div wire:click="registrantstatus({{ $registrant  }})" class="cursor-pointer">
                                                            {{ ucwords($registrant->registranttypeDescr) }}
                                                        </div>
                                                    </div>
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
                                        @else
                                            {{ dd($registrant) }}
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-gray-500 text-center">
                                                No Registrants found
                                                @if(strlen($this->search))
                                                    with search value: {{ $this->search }}
                                                @endif.
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

            </x-slot>

            <x-slot name="actions">

            </x-slot>

        </x-livewire-table-with-modal-forms>

    </div>

</div>



