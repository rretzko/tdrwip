<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-row w-12/12">

            {{-- SIDE BAR --}}
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
                            <span style="color: gold;">Due</span>: Total amount due <i>minus</i> amount collected through PayPal
                            and paid by check or cash.
                        </li>
                    </ul>
                </div>

            </section>

            {{-- MAIN SECTION --}}
            <section id="right" class="w-8/12 bg-white p-4">
                <h4 class="mb-3" style="font-size: 2rem;">
                    {{ $eventversion->name }} Participation Fee Roster
                </h4>

                {{-- RETURN TO AUDITION RESULTS PAGE --}}
                <div style="text-align: center; margin: 1rem 0;">
                    <a href="{{ route('auditionresults.index',['eventversion' => $eventversion]) }}"
                       style="color: darkred; background-color: lemonchiffon; padding: 0 1rem; border: 1px solid darkred; border-radius: 1rem;">
                        Return to Audition Results
                    </a>
                </div>

                {{-- TEACHER APPROVAL FOR STUDENTS --}}
                <div style="text-align: center;">
                    <a href="{{ route('participationfees.allow') }}"
                       style="background-color: @if($teacher_configs->where('user_id', auth()->id())->first()->paypal_participation_fee) darkred @else green @endif; color: white; padding: 0 1rem; margin: auto;border-radius: 1rem;"
                    >
                        Click to
                        @if($teacher_configs->where('user_id', auth()->id())->first()->paypal_participation_fee)
                          DISALLOW
                        @else
                            ALLOW
                        @endif
                         Student PayPal Payments For The ${{ $eventversion->eventversionconfigs->participation_fee_amount }}
                        Participation Fee
                    </a>
                </div>

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div style="display: flex; flex-direction: row;">
                        <div style="background-color: rgba(0,255,0,0.2); color: darkgreen; margin:auto; margin-bottom: 1rem; text-align: center; padding: 0 1rem;">
                            {{ session()->get('success')  }}
                        </div>
                    </div>
                @endif

                <style>
                    td,th{border: 1px solid black; text-align: center; padding:0 .25rem;}
                </style>
                <table style="margin: auto;">
                    <thead>
                        <tr>
                            <td colspan="7" style="text-align: right; padding-right: 1rem; border-top: 1px solid white; border-right: 1px solid white; border-left: 1px solid white;">
                                <a href="{{ route('participationfees.export') }}" style="color: blue; font-size: small;">
                                    Download csv
                                </a>
                            </td>
                        </tr>
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

                    {{-- SCHOOL PAYMENTS --}}
                    <tr style="background-color: black; color: white; font-weight: bold;">
                        <td colspan="4" style="text-align: right; padding-right: 1rem; border: 1px solid lightgray;">School PayPal Payment</td>
                        <td style="border: 1px solid lightgray;">
                            {{ auth()->user()->currentSchool()->paymentsParticipationPaypalSchoolFormatted() }}
                        </td>
                        <td colspan="2" style="border: 1px solid lightgray;"></td>
                    </tr>

                    </tbody>
                </table>

                {{-- STUDENT PAYMENT FORM --}}
                <div style="display: flex; flex-direction: row; justify-content: space-around; margin-top: 1rem;">
                    <x-forms.studentPaymentForm :registrants="$registrants" />
                </div>

                {{-- PAYPAL LINK --}}
@if((auth()->id() === 368) || (auth()->id() === 348))
                <div style="text-align: center;">
                    @if(auth()->user()->currentSchool()->paymentsParticipationBalanceDue())
                        <x-paypals.25.73.paypal_button
                            amountduenet="{{ auth()->user()->currentSchool()->paymentsParticipationBalanceDue() }}"
                            :eventversion="$eventversion"
                            :school="$school"
                        />
                    @else
                        <h4 class="font-bold mb-4 px-4" style="background-color: rgba(0,0,0,0.1); margin-top: 1rem;">PayPal Payment Amount Due: {{ auth()->user()->currentSchool()->paymentsParticipationBalanceDueFormatted() }}</h4>
                    @endif
                </div>
@endif
            </section>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>

