<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-row w-12/12">

            <section id="left" class="w-3/12 ">
                <div class="text-blue-100">
                    Audition Information Roster
                    @if(isset($scorestable) && $scorestable))
                     <!-- {{--   {!! $scorestable !!} --}} -->
                    @endif
                </div>

            </section>

            <section id="right" class="w-8/12 bg-white p-4">
                <h4 class="mb-3" style="font-size: 2rem;">
                    Your {{ $eventversion->name }} Audition Results
                </h4>

                <div style="text-align: center;">
                    @if($eventversion->id === 65)
                        <a href="/2021NJASC.pdf" target="_BLANK"
                            class="text-blue-500"
                        >
                    @elseif($eventversion->id === 66)
                        <a href="/2021SJCDA_Sr.pdf" target="_BLANK"
                           class="text-blue-500"
                        >
                    @elseif($eventversion->id === 67)
                        <a href="/2021SJCDA_Jr.pdf" target="_BLANK"
                           class="text-blue-500"
                        >
                    @elseif($eventversion->id === 69)
                        <a href="/2022NJAllShore.pdf" target="_BLANK"
                           class="text-blue-500"
                        >
                    @elseif($eventversion->id === 70)
                        <a href="/2021CJMEA.pdf" target="_BLANK"
                           class="text-blue-500"
                        >
                    @else
                        <a href="" class="tex-blue-500">
                    @endif
                     Download the full results roster here!
                    </a>
                </div>

                <style>
                    td,th{border: 1px solid black; text-align: center; padding:0 .25rem;}
                </style>
                <table style="margin: auto;">
                    <thead>
                        <tr>
                            <th>###</th>
                            <th>Reg.Id</th>
                            <th>Name</th>
                            <th>Voice</th>
                            <th>Score</th>
                            <th>Result</th>
                            <!-- <th>Detail</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($registrants AS $registrant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $registrant->id }}</td>
                            <td class="text-left">{{ $registrant->student->person->fullnameAlpha }}</td>
                            <td>{{ strtoupper($registrant->instrumentations->first()->abbr) }}</td>
                            <td>{{ $scoresummary->registrantScore($registrant) }}</td>
                            <td>{{ $scoresummary->registrantResult($registrant) }}</td>
                     <!-- {{--       <td>
                                <a href="{{ route('auditionresults.detail.show', ['registrant' => $registrant]) }}"
                                   class="text-blue-500"
                                >
                                    Score Detail
                                </a>
                            </td>
                            --}} -->
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </section>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>

