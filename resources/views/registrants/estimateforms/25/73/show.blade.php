<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Estimate Form') }}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb blurb="Estimate form for: {{ $eventversion->name }}"/>

                    </x-slot>

                    <x-slot name="table">

                        <div class="flex justify-between">
                            {{-- BACK TO ROSTER --}}
                            <div class="flex text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 20 20"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <a href="{{ route('registrants.index',['eventversion' => $eventversion]) }}"
                                   class="text-red-700 ml-2 pb-4">
                                    Return to Registrant Roster
                                </a>
                            </div>

                            {{-- BUTTON TO DOWNLOAD PDF --}}
                            <div class="bg-blue-400 text-xs pt-3 border rounded-2xl text-white px-2">
                                <!-- {{-- @deprecated 15-Sep-2022
                                @if(config('app.url') === 'http://localhost')
                                    <a href="{{ route('registrant.estimateform.download', ['eventversion' => $eventversion]) }}">
                                @else
                                    <a href="https://thedirectorsroom.com/registrant/estimateform/{{ $eventversion->id }}/download">
                                @endif
                            --}} -->
                                <a href="{{ route('registrant.estimateform.download', ['eventversion' => $eventversion]) }}">
                                    Download Estimate Form
                                </a>

                            </div>
<!-- {{--
                            <div class="bg-blue-400 text-xs pt-3 border rounded-2xl text-white px-2">
                                <a href="https://thedirectorsroom.com/assets/docs/pdfs/9/71/DirectorAgreementForAudioRecordingMP3Submissions_20220201.pdf" target="_NEW">
                                    Download Directors Agreement
                                </a>
                            </div>
--}} -->
                        </div>

                        {{-- ESTIMATE FORM --}}
                        <div class="my-2 overflow-x-auto sm:mx-2 lg:mx-2 ">

                            {{-- BANNER --}}
                            <header class="flex justify-between">
                                <div>
                                   <!-- <img src="\assets\images\njmea_logo_state.jpg" alt="NJMEA logo"/> -->
                                </div>

                                <div class="flex flex-col">
                                    <div class="uppercase border-b text-center">
                                        {{ $eventversion->name }}
                                    </div>
                                    <div class="uppercase text-center">
                                        2021-2022 TEACHER ESTIMATE FORM
                                    </div>
                                    <div class=" text-center">
                                        {{ auth()->user()->person->fullName }}
                                    </div>
                                    <div class=" text-center">
                                        {{ $school->shortName }}
                                    </div>
                                </div>
                            </header>

                            {{-- COUNTY SELECTION for NJ All-State --}}
                            <div class="border border-black p-2 bg-gray-200">
                                @if($counties->count())
                                    @if(config('app.url') === 'http://localhost')
                                        <form method="post" action="{{ route('school.county') }}" >
                                    @else
                                        <form method="post" action="https://thedirectorsroom.com/registrant/estimateform/county" >
                                    @endif
                                        @csrf
                                        The county for <b>{{ $school->shortName }}</b> is:
                                        <select name="county_id" class="@if($updated) bg-green-100 @endif">
                                            @foreach($counties AS $county)
                                                <option value="{{ $county->id }}"
                                                    @if($school->county_id === $county->id) SELECTED @endif
                                                >{{ $county->name }}</option>
                                            @endforeach
                                        </select>
                                        <input class="ml-2 bg-blue-100 px-4" type="submit" name="submit" id="submit" value="Update" >
                                    </form>

                                    <div>
                                        Send this pdf to:
                                        <div><b>{{ $sendto['name'] }}</b></div>
                                        <div>{{ $sendto['address01'] }}</div>
                                        <div>{{ $sendto['address02'] }}</div>
                                        @if(strlen($sendto['address03']))<div>{{ $sendto['address03'] }}</div> @endif
                                        <div>{!! $sendto['email'] !!}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- REGISTRANT ROSTER --}}
                            <div class="flex flex-col">

                                {{-- HEADER --}}
                                <!-- {{--
                                <h2 class="text-center w-full border-b">
                                    {{ $eventversion->eventversionconfigs->max_count }} STUDENTS MAXIMUM
                                </h2>
                                --}} -->

                                <h3 class="text-center w-full border-b" style="color: darkred; font-weight: bold;">
                                   YOUR REGISTERED STUDENTS WILL BE AUTOMATICALLY DISPLAYED BELOW.<br />
                                    HANDWRITTEN ENTRIES WILL <u>NOT</u> BE ACCEPTED.
                                </h3>

                                {{-- ROSTER TABLE --}}
                                <style>
                                    table{border-collapse: collapse;}
                                    td,th{border: 1px solid black; padding: 0 .25rem;}
                                </style>
                                <table class="mb-4">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Voice Part</th>
                                        <th>Grade</th>
                                        <th>Fee</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- {{--
                                    @for($i=0;$i<$eventversion->eventversionconfigs->max_count;$i++)
                                        @if(isset($registrants[$i]))
                                            <tr>
                                                <td class="text-center">{{ ($i + 1) }}</td>
                                                <td class="">{{ $registrants[$i]->student->person->fullNameAlpha }}</td>
                                                <td class="text-center">{{ $registrants[$i]->instrumentations->first()->descr }}</td>
                                                <td class="text-center">{{ $registrants[$i]->student->grade }}</td>
                                                <td class="text-center">${{ $eventversion->eventversionconfigs->registrationfee * ($i + 1) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="text-center">{{ ($i + 1) }}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">${{ $eventversion->eventversionconfigs->registrationfee * ($i + 1) }}</td>
                                            </tr>
                                        @endif

                                    @endfor
                                    --}} -->
                                    {{-- FORCE REBUILD OF DEPLOY --}}
                                    @forelse($registrants AS $registrant)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="">{{ $registrant->student->person->fullNameAlpha }}</td>
                                                <td class="text-center">{{ $registrant->instrumentations->first()->descr }}</td>
                                                <td class="text-center">{{ $registrant->student->grade }}</td>
                                                <td class="text-center">${{ $eventversion->eventversionconfigs->registrationfee * ($loop->iteration) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" style="text-align: center">No registrants found</td>
                                            </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                {{-- SUMMARY TABLE --}}
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="border-l-0 border-t-0 "></th>
                                        @foreach($eventversion->instrumentations() AS $instrumentation)
                                            <th class="uppercase">{{ $instrumentation->abbr }}</th>
                                        @endforeach
                                        <th>Total Fees</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Voice Part Totals</td>
                                        @foreach($eventversion->instrumentations() AS $instrumentation)
                                            <th class="{{ (! $registrantsbyinstrumentation[$instrumentation->id]) ? 'text-gray-300' : '' }}">
                                                {{ $registrantsbyinstrumentation[$instrumentation->id] }}
                                            </th>
                                        @endforeach
                                        <td class="text-center">${{ array_sum($registrantsbyinstrumentation) * $eventversion->eventversionconfigs->registrationfee }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                {{-- MEMBERSHIP CARD --}}
                                @if($membership && strlen($membership->membership_card_path))

                                    <div id="membership" class="center mt-8 border border-black p-2">
                                        <header class="text-center text-xl font-bold">
                                            Membership Information
                                        </header>

                                        <div id="stats" class="my-4">
                                            <div class="flex">
                                                <label style="width: 6rem;">Organization</label>
                                                <div
                                                    class="font-bold ml-1">{{ $eventversion->event->organization->name }}</div>
                                            </div>
                                            <div class="flex">
                                                <label style="width: 6rem;">Status</label>
                                                <div
                                                    class="font-bold ml-1">{{ $membership->membershiptype->descr }}</div>
                                            </div>
                                            <div class="flex">
                                                <label style="width: 6rem;">Expiration</label>
                                                <div class="font-bold ml-1">{{ $membership->expirationMdy() }}</div>
                                            </div>
                                        </div>
                                        <div id="mt-4">
                                            <img src="{{ $membership_card_url }}" width="200" />
                                        </div>
                                    </div>
                                @elseif($membership)
                                    <table class="mt-4 bg-gray-200">
                                        <tr>
                                            <td>
                                                The downloaded pdf will contain an additional page on which a copy of your
                                                NAfME membership card or verification of current status must be attached.
                                                Your organization membership information and card image can be automatically
                                                added by <a href="{{ route('organization.membershipcard', $eventversion->event->organization) }}"
                                                style="color: blue;">clicking here</a>!
                                            </td>
                                        </tr>
                                    </table>
                                @else
                                    {{-- do nothing --}}
                                @endif

                                {{-- PAYPAL CUSTOM BUTTON WITH IPN--}}
                                <section class="mt-4">

                                    <div class="px-4">
                                        <h4 class="font-bold mb-4 px-4" style="background-color: rgba(0,0,0,0.1);">Payment Amount Due: ${{ number_format($amountduenet, 2) }}</h4>
                                        @if($amountduenet > 0)
                                            <div class="m-auto" style="width: 12rem;">
                                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" >
                                                    <!-- Identify your business so that you can collect the payments. -->
                                                    <input type="hidden" name="business" value="morrisareahonorchoir@gmail.com" >
                                                    <input type="hidden" name="notify_url" value="https://thedirectorsroom.com/update_account" >
                                                    <input type="hidden" name="custom" value="{{ auth()->id().'*teacher*'.$eventversion->id.'*'.$school->id.'*'.$amountduenet }}" >
                                                    <!-- Specify a subscribe button -->
                                                    <input type="hidden" name="cmd" value="_xclick" >
                                                    <!-- Identify the registrant -->
                                                    <input type="hidden" name="item_name" value="{{ $eventversion->name }}" >
                                                    <input type="hidden" name="item_number" value="{{ $eventversion->id }}" >
                                                    <input type="hidden" name="on0" value="{{ auth()->user()->name }}" >
                                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}" >
                                                    <input type="hidden" name="currency_code" value="USD" >
                                                    <input type="hidden" name="amount" value="{{ $amountduenet }}" >
                                                    <!-- display the payment button -->
                                                    <input class="rounded-full" type="image" name="submit" src="/assets/images/pp.png">

                                                </form>

                                            </div>
                                        @endif
                                    </div>

                                </section>

                                {{-- COVID ADVISORY --}}
                                <!-- Decision to exclude covid advisory from estimate form: Barbara Retzko 2022-Feb-01
                                <x-covid.njacdaadvisory />
                                -->
                            </div>

                        </div>

                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
