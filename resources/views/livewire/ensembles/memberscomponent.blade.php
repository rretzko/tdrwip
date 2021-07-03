<div>

    <x-livewire-table-with-modal-forms >

        <x-slot name="title">
            {{ __('Ensemble Members Information') }}
        </x-slot>

        <x-slot name="description">

            <x-sidebar-blurb blurb="Add or edit your ensemble member information here." />

            <x-sidebar-blurb blurb="Use the Advanced Search feature to additionally filter the display." />

            <x-sidebar-blurb blurb="Click the edit button to display an individual ensemble member's detailed information." />

            <x-sidebar-blurb blurb="Members can be uploaded via .csv file by using the 'Import' option under the 'Bulk Actions' drop-down." />

        </x-slot>

        <x-slot name="table">

            <div class="flex justify-end space-x-2 mb-2">
                <x-inputs.dropdowns.perpage />
                <x-inputs.dropdowns.bulkactions import />
                <x-buttons.button-add toggle="showaddmodal"/>
            </div>

            <!-- {{--
            <div class="mb-2">
                <x-navs.currentalumall />
            </div>
            --}} -->

            {{-- beginning of tailwindui table --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                    <div class="space-y-2 overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <div class="flex space-x-4">
                            {{-- SCHOOL YEAR FILTER --}}
                            <div class="flex space-x-2">
                                <x-inputs.select label="School Year" :options="$schoolyears" for="schoolyear_id"
                                                 currentvalue="{{ $schoolyear_id }}"
                                                 placeholder="All"
                                                 immediate
                                />
                                {{-- SEARCH FILTER --}}
                                <x-inputs.text wire:model.debounce.1s="search"
                                               for="search"
                                               label=""
                                               placeholder="Search member name..."/>
                            </div>
                        <!-- {{-- SUPPRESS ADVANCED FILTERS
                            <div class="flex text-sm text-gray-600">
                                <x-buttons.button-link wire:click="$toggle('showfilters')">
                                    @if($showfilters) Hide @endif Advanced Filters @if(strlen($filterstring)) (current: "{{ $filterstring }}") @endif
                                </x-buttons.button-link>
                            </div>
--}} -->
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
                        </div>

                        <x-tables.surgetable class="w-full ">
                            <x-slot name="head" >

                                <x-tables.heading >
                                    <x-inputs.checkbox class="pr-0 w-4" for="selectpage" label=""/>
                                </x-tables.heading>

                                <x-tables.heading wire:click.prevent="sortField('name')"
                                                  sortable
                                                  direction="asc"
                                                  :direction="$sortfield === 'name' ? $sortdirection : null"
                                >
                                    Name
                                </x-tables.heading>

                                <x-tables.heading wire:click.prevent="sortField('instrumentation')"
                                                  sortable
                                                  direction="asc"
                                                  :direction="$sortfield === 'instrumentation' ? $sortdirection : null"
                                >
                                    Voice Part
                                </x-tables.heading>

                                <x-tables.heading >
                                    School Years
                                </x-tables.heading>

                                <th><span class="sr-only">Edit</span></th>
                                <th><span class="sr-only">Assets</span></th>

                            </x-slot>

                            <x-slot name="body" >

                                @if($selectpage)
                                    <x-tables.row class="bg-gray-200" wire:key="row-message">
                                        <x-tables.cell colspan="7">
                                            @unless($selectall)
                                                <div>You have selected <strong>{{ count($selected) }}</strong> ensembles, do
                                                    you want to select all <strong>{{ $ensembles->count() }}</strong>?
                                                    <x-buttons.button-link wire:click="selectAll"
                                                                           class="ml-1 text-blue-600">Select All
                                                    </x-buttons.button-link>
                                                </div>
                                            @else
                                                <span>You have selected all <strong>{{ $ensembles->count() }}</strong>
                                                    ensembles.</span>
                                            @endunless
                                        </x-tables.cell>
                                    </x-tables.row>
                                @endif

                                @forelse($members AS $m)
                                    <x-tables.row wire:loading.class.delay="opacity-50" altcolor="{{$loop->iteration % 2}}" wire:key="row-{{ $ensemble->id }}">

                                        <x-tables.cell>
                                            <x-inputs.checkbox value="{{ $m->user_id }}" class="" for="selected" label="" />
                                        </x-tables.cell>

                                        <x-tables.cell>
                                            {{ $m->person->fullNameAlpha }}
                                        </x-tables.cell>
                                        <x-tables.cell>
                                            {{ $m->instrumentation->formattedDescr() }}
                                        </x-tables.cell>

                                        <x-tables.cell>
                                            Schoolyears?
                                        </x-tables.cell>

                                        <x-tables.cell>
                                            <x-buttons.button-link
                                                wire:click.defer="edit({{ $m->user_id }})"
                                                class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                            >
                                                Edit
                                            </x-buttons.button-link>
                                        </x-tables.cell>

                                        <x-tables.cell>
                                            <x-buttons.button-link
                                                wire:click.defer="edit({{ $m->user_id }})"
                                                class="border border-green-500 rounded px-2 bg-green-600 text-white hover:bg-green-400"
                                            >
                                                Assets
                                            </x-buttons.button-link>

                                        </x-tables.cell>

                                    </x-tables.row>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-gray-500 text-center">
                                            No Members found @if(strlen($this->search)) with search value: {{ $this->search }}@endif.
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
                    <x-modals.ensemblemember
                        :ensemble="$ensemble"
                        :instrumentations="$instrumentations"
                        instrumentationid="{{ $instrumentation_id }}"
                        :member="$editmember"
                        :members="$members"
                        :nonmembers="$nonmembers"
                        schoolyear_id="$schoolyear_id"
                        :schoolyears="$schoolyears"
                        userid="{{ $user_id }}"
                    />
                @endif
            </div>

            {{-- DELETE ENSEMBLE --}}
            <div>
                @if($showDeleteModal)
                    <x-modals.delete :selected="$selected" objectname="ensemble" />
                @endif
            </div>



        </x-slot>

        <x-slot name="actions" >


        </x-slot>

    </x-livewire-table-with-modal-forms>

</div>
