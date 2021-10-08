<x-layouts.adjudicationlayout >

    <div class="bg-white w-11/12 m-auto p-2">
        <h2 class="text-center text-xl">
            {{ $eventversion->name }} Adjudication for: <b>{{ $room->descr }}</b>
        </h2>
        <div>
            Adjudicators in this room are:
            <ul>
                @foreach($room->adjudicators AS $adjudicator)
                    <li>{{ $adjudicator->user->person->fullName }}</li>
                @endforeach
            </ul>
        </div>
    </div>

</x-layouts.adjudicationlayout>
