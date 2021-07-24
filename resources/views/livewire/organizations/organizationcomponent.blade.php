<div>
    <div>
        <x-livewire-table-with-modal-forms >

            <x-slot name="title">
                {{ __('Organization Information') }}
            </x-slot>

            <x-slot name="description">

                <x-sidebar-blurb blurb="Add or edit your organization information here." />

                <x-sidebar-blurb blurb="Organizations can have the following status:
                    <ul class='ml-4'>
                        <li><b>EVENTS, TDR</b>: Directors in this organization are using TheDirectorsRooms.com and
                            this organization is using AuditionForms.com for managing their auditioned events
                        </li>
                        <li><b>TDR</b>: Directors from this organization are using TheDirectorsRoom.com</li>
                        <li><b>NONE</b>: No Directors belong to this organization</li>
                    <ul>" />

                <x-sidebar-blurb blurb="If you are a member of an organization, you will show a green <b>Member</b> badge. If
                    you are not a member, you will display a blue 'Request' button to request membership.
                    Requests will be emailed to that organizations Membership Manager.  Hover over the 'Request' button
                    to see the contact information for the Membership Manager." />

                <x-sidebar-blurb blurb="The <b>Card</b> button allows you to upload your membership card into the
                system.  This is often useful for organzations using AuditionForms.com to manage their auditioned
                events. These organization will have a green 'Participating' status badge." />



            </x-slot>

            <x-slot name="table">
                {{-- Organizations table --}}
                {{-- Per Page and Bulk actions are commented out but left for future usage --}}
                <div class="flex justify-end pr-6 space-x-2">
                    <!-- <x-inputs.dropdowns.perpage />
                    <x-inputs.dropdowns.bulkactions :selected="$selected" /> -->
                    <x-buttons.button-add toggle="showaddmodal" />
                </div>

                {{-- beginning of tailwindui table --}}

                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                    <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                        <div class="space-y-4 overflow-hidden border-b border-gray-200 sm:rounded-lg">

                            {{-- SEARCH is commented out but left for future usage --}}
                            <!-- {{-- <div class="flex space-x-4">
                                <!-- {{-- <div class="flex">
                                    <x-inputs.text wire:model.debounce.1s="search"
                                                   for="search"
                                                   label=""
                                                   placeholder="Search organization name..."/>
                                </div>

                            <div class="flex text-sm text-gray-600">
                                <x-buttons.button-link wire:click="$toggle('showfilters')">
                                    @if($showfilters) Hide @endif Advanced Filters @if(strlen($filterstring)) (current: "{{ $filterstring }}") @endif
                                </x-buttons.button-link>
                            </div>

                            </div>

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
                            </div> --}} -->

                            <x-tables.surgetable class="w-full">
                                <x-slot name="head" >

                                    <th title="Parent" ><span class="text-gray-200">P</span></th>
                                    <th title="Section" ><span class="text-gray-200">S</span></th>
                                    <th title="State" ><span class="text-gray-200">T</span></th>
                                    <th title="Region" ><span class="text-gray-200">R</span></th>
                                    <th title="Subregion" ><span class="text-gray-200">U</span></th>

                                    <th class="px-2" title="Is this organization participating in AuditionSuite.org?">Status?</th>
                                    <th class="px-2" title="Does the system recognize you as a member of this organization?">Member?</th>
                                    <th class="px-2" title="Does the system have a current copy of your membership card?">Card?</th>

                                </x-slot>

                                <x-slot name="body" >

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

                                    @forelse($organizations AS $organization)
                                        <x-tables.row
                                            wire:loading.class.delay="opacity-50"
                                            style="{{ $organization->hasChildren ? 'border-bottom: 0px solid transparent;' : '' }} "
                                            wire:key="row-{{ $organization->id }}"
                                            altcolor="{{$loop->even}}"

                                        >
                                            <td colspan="5"
                                                   class="px-2 @if($organization->hasChildren) py-0 @endif">
                                                <b>{{ $organization->name.' ('.$organization->id.')' }}</b>
                                            </td>

                                            <td class="text-center">
                                                {!! $organization->auditionsuiteStatus !!}
                                            </td>

                                            <td>
                                                <x-buttons.button-link
                                                    wire:click.defer="edit({{ $organization->id }})"
                                                    class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                                >
                                                    Member
                                                </x-buttons.button-link>
                                            </td>

                                            <td style="padding-right: .5rem;">
                                                <a href="#"
                                                   class="border border-green-500 rounded px-2 bg-green-600 text-white hover:bg-green-400"
                                                   title="Click to add your {{ $organization->abbr }} membership card"
                                                >
                                                    Card
                                                </a>

                                            </td>

                                        </x-tables.row>

                                        {{-- ADD SECTION ROW IF PARENT HAS CHILDREN --}}
                                        @if($organization->hasChildren)
                                            @foreach($organization->children() AS $child)
                                                <x-tables.row
                                                    wire:loading.class.delay="opacity-50"
                                                    wire:key="row-{{ $child->id }}"
                                                    style="border-top: 0px solid transparent;"
                                                    altcolor="{{$loop->parent->even}}"
                                                >

                                                    <td class=py-1"></td>

                                                    <td colspan="4"
                                                        class="py-1" title="{{ $child->name }}">
                                                        {{ $child->abbr.' ('.$child->id.')' }}
                                                    </td>

                                                    <td class="text-center py-1">
                                                        {!! $child->auditionsuiteStatus !!}
                                                    </td>

                                                    <td class=" py-1">
                                                        <x-buttons.button-link
                                                            wire:click.defer="edit({{ $child->id }})"
                                                            class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                                        >
                                                            Member
                                                        </x-buttons.button-link>
                                                    </td>

                                                    <td class=" py-1">
                                                        <a href="#"
                                                           class="border border-green-500 rounded px-2 bg-green-600 text-white hover:bg-green-400"
                                                           title="Click to add your {{ $child->abbr }} membership card"
                                                        >
                                                            Card
                                                        </a>

                                                    </td>

                                                </x-tables.row>

                                                {{-- ADD SECTION ROW IF CHILD HAS GRANDCHILDREN --}}

                                                @if($child->hasChildren)
                                                    @foreach($child->children() AS $grandchild)
                                                        <x-tables.row
                                                            wire:loading.class.delay="opacity-50"
                                                            wire:key="row-{{ $grandchild->id }}"
                                                            style="border-top: 0px solid transparent;"
                                                            altcolor="{{$loop->parent->parent->even}}"
                                                        >

                                                            <td class="py-1"></td>

                                                            <td class="py-1"></td>

                                                            <td colspan="3"
                                                                class="py-1" title="{{ $grandchild->name }}">
                                                                {{ $grandchild->abbr.' ('.$grandchild->id.')' }}
                                                            </td>

                                                            <td class="text-center py-1">
                                                                {!! $grandchild->auditionsuiteStatus !!}
                                                            </td>

                                                            <td class=" py-1">
                                                                <x-buttons.button-link
                                                                    wire:click.defer="edit({{ $grandchild->id }})"
                                                                    class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                                                >
                                                                    Member
                                                                </x-buttons.button-link>
                                                            </td>

                                                            <td class=" py-1">
                                                                <a href="#"
                                                                   class="border border-green-500 rounded px-2 bg-green-600 text-white hover:bg-green-400"
                                                                   title="Click to add your {{ $grandchild->abbr }} membership card"
                                                                >
                                                                    Card
                                                                </a>

                                                            </td>

                                                        </x-tables.row>
                                                    @endforeach

                                                    {{-- ADD SECTION ROW IF GRANDCHILD HAS GREATGRANDCHILDREN --}}

                                                    @if($grandchild->hasChildren)
                                                        @foreach($grandchild->children() AS $greatgrandchild)
                                                            <x-tables.row
                                                                wire:loading.class.delay="opacity-50"
                                                                wire:key="row-{{ $greatgrandchild->id }}"
                                                                style="border-top: 0px solid transparent;"
                                                                altcolor="{{$loop->parent->parent->even}}"
                                                            >

                                                                <td class="py-1"></td>

                                                                <td class="py-1"></td>

                                                                <td class="py-1"></td>

                                                                <td colspan="2"
                                                                    class="py-1" title="{{ $greatgrandchild->name }}">
                                                                    {{ $greatgrandchild->abbr.' ('.$greatgrandchild->id.')' }}
                                                                </td>

                                                                <td class="text-center py-1">
                                                                    {!! $greatgrandchild->auditionsuiteStatus !!}
                                                                </td>

                                                                <td class=" py-1">
                                                                    <x-buttons.button-link
                                                                        wire:click.defer="edit({{ $greatgrandchild->id }})"
                                                                        class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                                                    >
                                                                        Member
                                                                    </x-buttons.button-link>
                                                                </td>

                                                                <td class=" py-1">
                                                                    <a href="#"
                                                                       class="border border-green-500 rounded px-2 bg-green-600 text-white hover:bg-green-400"
                                                                       title="Click to add your {{ $greatgrandchild->abbr }} membership card"
                                                                    >
                                                                        Card
                                                                    </a>

                                                                </td>

                                                            </x-tables.row>
                                                        @endforeach
                                                    @endif

                                                @endif

                                            @endforeach
                                        @endif

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-gray-500 text-center">
                                            No Organization found @if(strlen($this->search)) with search value: {{ $this->search }}@endif.
                                        </td>
                                    </tr>

                                @endforelse
                                <!-- {{-- SUPPRESS PAGINATION
                                <div class="mb-2">
                                    {{$ensembles->count() ? $ensembles->links() : ''}}
                                </div>
--}} -->
                                </x-slot>

                            </x-tables.surgetable>

                        <!-- {{-- SUPPRESS PAGINATION
                        <div class="mb-2">
                            @if($ensembles->count() > 5)
                                {{$ensembles->count() ? '$ensembles->links()' : ''}}
                            @endif
                        </div>
--}} -->
                        </div>
                    </div>
                </div>

                {{-- MODALS --}}
                {{-- ADD/EDIT STUDENT --}}
                <div>
                    @if($showeditmodal)
                <!-- {{--        <x-modals.ensemble :ensemble="$editensemble" :ensembletypes="$ensembletypes" :years="$years" /> --}} -->
                    @endif
                </div>

                {{-- DELETE ENSEMBLE --}}
                <div>
                    @if($showDeleteModal)
                       <!-- {{-- <x-modals.delete :selected="$selected" objectname="ensemble" /> --}} -->
                    @endif
                </div>



            </x-slot>

            <x-slot name="actions" >


            </x-slot>

        </x-livewire-table-with-modal-forms>
    </div>



</div>
