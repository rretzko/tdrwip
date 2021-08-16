<div>
    <div>
        <x-livewire-table-with-modal-forms>

            <x-slot name="title">
                {{ __('Pitch and Other Audition Files') }}
            </x-slot>

            <x-slot name="description">

                <x-sidebar-blurb blurb="Use this page to play or download {{ $eventversion->name }} audition files for your students."/>

            </x-slot>

            <x-slot name="table">

                <div class="flex justify-center space-x-2" id="selections">

                    <div class="inputgroup flex flex-col mb-4">
                        <label class="text-center" for="instrumentation_id">Voice Part</label>
                        <x-inputs.select
                            currentvalue= 0
                            immediate=true
                            label=""
                            for="instrumentation_id"
                            placeholder="all"
                            :options=$instrumentations
                        />
                    </div>

                    <div class="inputgroup flex flex-col">
                        <label class="text-center" for="filecontenttype_id">File type</label>
                        <x-inputs.select
                            currentvalue= 0
                            immediate=true
                            label=""
                            for="filecontenttype_id"
                            placeholder="all"
                            :options=$filecontenttypes
                        />
                    </div>

                </div>

                <x-tables.surgetable class="w-full">
                    <x-slot name="head">

                        <th class="px-2" >###</th>
                        <th class="px-2">File type</th>
                        <th class="px-2">Voice Part</th>
                        <th class="px-2">Descr</th>
                        <th class="px-2" title="Audition file">File</th>

                    </x-slot>

                    <x-slot name="body">
                        @foreach($pitchfiles AS $pitchfile)
                            <x-tables.row
                                wire:loading.class.delay="opacity-50"
                                style=""
                                wire:key="row-{{ $pitchfile->id }}"
                                altcolor="{{$loop->even}}"
                            >
                                <x-tables.cell>
                                    {{ $loop->iteration }}
                                </x-tables.cell>


                                <x-tables.cell class="text-center">
                                    {{ $pitchfile->filecontenttypedescr }}
                                </x-tables.cell>

                                <x-tables.cell class="text-center">
                                    {{ $pitchfile->instrumentationabbr }}
                                </x-tables.cell>

                                <x-tables.cell class="text-center">
                                    {{ $pitchfile->descr }}
                                </x-tables.cell>

                                <x-tables.cell class="text-center">
                                    @if(substr($pitchfile->location,-4) === '.pdf')
                                        <a href="{{ $pitchfile->location }}"
                                           class="text-blue-700"
                                           target="_BLANK">
                                            {{ $pitchfile->descr }} pdf
                                        </a>
                                    @else
                                        <audio controls>
                                            <source src="{{ $pitchfile->location }}" type="audio/ogg">
                                            <source src="{{ $pitchfile->location }}" type="audio/mpeg">
                                            Your browser does not support the audio tag.
                                        </audio>
                                    @endif
                                </x-tables.cell>

                            </x-tables.row>
                        @endforeach

                    </x-slot>
                </x-tables.surgetable>


            </x-slot>

        </x-livewire-table-with-modal-forms>
    </div>
</div>
