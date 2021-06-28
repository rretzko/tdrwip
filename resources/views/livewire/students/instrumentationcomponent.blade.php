<div>
    Instrumentation for {{ $student->person->fullName }}

    {{ $studentinstrumentations->count() }} instrumentations found.

    <x-inputs.group label="Instrumentations" for="instrumentation_id">
        <div class="flex flex-col space-y-2">
            @if($studentinstrumentations->count())
                @foreach($studentinstrumentations AS $key => $studentinstrumentation)
                    <div class="flex flex-row space-x-2 ">
                        <div>
                            {!! ucwords($studentinstrumentation->instrumentationbranch->descr).':<b>'.$studentinstrumentation->formattedDescr().'</b>' !!}
                        </div>

                        <div >
                            <x-buttons.button-delete id="{{ $studentinstrumentation->id }}"/>
                        </div>

                        @if(! $key) {{-- Display 'Add' button on the first line only --}}
                            <div >
                                <x-buttons.button-add-icon toggle="instrumentation" />
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

            @if((! $studentinstrumentations) || $addinstrumentation)
                <div class="flex flex-row space-x-2">
                    <div>
                        <select wire:model="branch_id">
                            @foreach($branches AS $branch)
                                <option value="{{ $branch->id }}">{{ $branch->descr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-inputs.select label="" for="instrumentation_id" :options="$instrumentations" key="instrumentation1" currentvalue="" />
                    </div>
                </div>
            @endif
        </div>
    </x-inputs.group>
</div>
