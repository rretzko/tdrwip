<x-layouts.adjudicationlayout >

    {{-- PAGE HEADER --}}
    <div class="bg-white w-11/12 m-auto p-2">
        <h2 class="text-center text-xl border-b border-gray-300">
            {{ $eventversion->name }} Adjudication for: <b>{{ $room->descr }}</b>
        </h2>

        <div class=" border-b border-gray-300 pb-2">
            Adjudicators in this room are:
                <div class="flex flex-wrap justify-center space-x-4">
                    @foreach($room['adjudicators'] AS $adjudicator)
                        <div class="border border-black p-2">{!! $adjudicator->bioBlock !!}</div>
                    @endforeach
                </div>
        </div>

        {{-- SUMMARY NUMBERS --}}
        <div class="my-4 flex justify-center border-b border-gray-300">
            <div>This room has:</div>
            <ul class="ml-5">
                <li>Registrants: {{ $registrants->count() }}</li>
                <li>Adjudicated: ###</li>
                <li>Remaining: ###</li>
                <li>Partial adjudications: ###</li>
            </ul>
        </div>

        {{-- REGISTRANT IDS --}}
        <div class="flex flex-wrap space-x-1 space-y-1 text-sm">
            @foreach($registrants AS $registrant)
                <div class="border border-gray-700">
                    {{ $registrant->id }}
                </div>
            @endforeach
        </div>
    </div>

</x-layouts.adjudicationlayout>
