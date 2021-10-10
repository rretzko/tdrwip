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
        <div class="flex flex-col pb-1 mb-3 border-b border-gray-300">
            <div class="flex flex-wrap">
                @foreach($registrants AS $registrant)
                    <div class="border border-gray-700 text-sm mb-1 mr-1">
                        @if(config('app.url') === 'http://localhost')
                            <a href="{{ route('registrants.adjudication.show', ['registrant' => $registrant]) }}"
                               class="text-black {{ $registrant->adjudicationStatusBackgroundColor($room) }}">
                                {{ $registrant->id }}
                            </a>
                        @else
                            <a href="">
                                {{ $registrant->id }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            <div id="legend" class="flex flex-row justify-center my-1 text-xs">
                <div class="border border-black px-2" title="No scores found">Unauditioned</div>
                <div class="border border-black px-2 bg-yellow-100" title="Incomplete set of scores found">Partial</div>
                <div class="border border-black px-2 bg-green-100" title="Complete set of scores found">Completed</div>
                <div class="border border-black px-2 bg-red-100" title="Scores are out of tolerance">Tolerance</div>
                <div class="border border-black px-2 bg-blue-100" title="More than expected number of scores found">Excess</div>
                <div class="border border-black px-2 bg-gray-300" title="Something unexpected has occurred">Error</div>
            </div>
        </div>

        {{-- VIEWPORT & SCORING --}}
        <div id="viewport-scoring" class="flex flex-row flex-wrap space-x-2">
            <div id="viewport">
                <div class="flex justify-center">
                    @if($auditioner)
                        <div class="flex flex-col">
                            <div class="text-center bg-indigo-100 border border-indigo-700">
                                Now adjudicating: {{ $auditioner->id }}: {{ strtoupper($auditioner->instrumentations->first()->abbr) }}
                            </div>
                            <div class=" mb-1">
                                {!! $auditioner->fileviewport(\App\Models\Filecontenttype::find(1)) !!}
                            </div>
                            <div class="text-center border border-black rounded bg-gray-100">
                                <a href="/registrants/adjudication/{{ $eventversion->id }}" class="text-black">
                                    Cancel
                                </a>
                            </div>
                        </div>

                        <div id="scoring">
                            <form method="post" action="{{ route('registrants.adjudication.update', ['registrant' => $auditioner->id]) }}" >

                                @csrf

                                <x-adjudication.scoresheets.index
                                    :eventversion="$eventversion"
                                    :room="$room"
                                    :scoringcomponents="$scoringcomponents"
                                />
                                <div class="mt-2 text-center">
                                    <input class="bg-black text-white rounded px-2" type="submit" name="submit" id="submit" value="Submit" />
                                </div>
                            </form>
                        </div>

                    @endif
                </div>
            </div>



        </div>
    </div>

</x-layouts.adjudicationlayout>
