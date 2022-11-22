<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-row w-12/12">

            <section id="left" class="w-3/12 ">
                <div class="text-blue-100">
                    Participation Fee Roster
                </div>

            </section>

            <section id="right" class="w-8/12 bg-white p-4">
                <h4 class="mb-3" style="font-size: 2rem;">
                    {{ $eventversion->name }} Participation Fee Roster
                </h4>

                {{-- RETURN TO AUDITION RESULTS PAGE --}}
                <div style="text-align: center; margin: 1rem 0;">
                    <a href="{{ route('auditionresults.index',['eventversion' => $eventversion]) }}" style="color: darkred;">
                        Back to Audition Results
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
                            <th>PayPal</th>
                            <th>Other</th>
                            <th>Due</th>
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
                            <td>PP</td>
                            <td>Oth</td>
                            <td style="background-color: rgba(0,0,0,0.1);">Due</td>
                        </tr>
                    @endforeach
                    {{-- BALANCE DUE --}}
                    <tr style="background-color: rgba(0,0,0,0.1);">
                        <td colspan="6" style="text-align: right; font-weight: bold;">Balance Due</td>
                        <td style="font-weight: bold;">$</td>
                    </tr>
                    </tbody>
                </table>

                {{-- PAYPAL LINK --}}
                <div style="text-align: center;">
                    PayPal Link Here...
                </div>
            </section>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>

