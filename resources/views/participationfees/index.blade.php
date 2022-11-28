<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-row w-12/12">

            <section id="left" class="w-3/12 ">
                <div class="text-blue-100">
                    Participation Fee Roster
                    <ul>
                        <li>
                            <span style="color: gold;">PayPal</span>: Participation fees collected through PayPal.
                        </li>
                        <li>
                            <span style="color: gold;">Other</span>: Participation fees collected by you excluding PayPal payments.
                        </li>
                        <li>
                            <span style="color: gold;">Due</span>: Total amount due <i>minus</i> amount collected through PayPal.
                        </li>
                    </ul>
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
                            <th>
                                <span title="Amount paid through PayPal" style="color:green">
                                    PayPal
                                </span>
                            </th>
                            <th>
                                <span title="Amount collected NOT PayPal" style="color:green">
                                    Other
                                </span>
                            </th>
                            <th>
                                <span title="Total Due - Amount paid through PayPal" style="color:green">
                                    Due
                                </span>
                            </th>
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
                            <td>{{ $registrant->paymentsParticipationPaypalFormatted() }}</td>
                            <td>{{ $registrant->paymentsParticipationXPaypalFormatted() }}</td>
                            <td style="background-color: rgba(0,0,0,0.1);">{{ $registrant->paymentsParticipationXPaypalBalanceDueFormatted() }}</td>
                        </tr>
                    @endforeach

                    {{-- TOTALS --}}
                    <tr style="background-color: rgba(0,0,0,0.1); font-weight: bold;">
                        <td colspan="4" style="text-align: right;">Totals</td>
                        <td>
                            {{ auth()->user()->currentSchool()->paymentsParticipationPaypalFormatted() }}
                        </td>
                        <td>
                            {{ auth()->user()->currentSchool()->paymentsParticipationXPaypalFormatted() }}
                        </td>
                        <td >
                            {{ auth()->user()->currentSchool()->paymentsParticipationXPaypalBalanceDueFormatted() }}
                        </td>
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

