<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-row">
<!-- {{--
            @if($teachers->count())
                <x-impersonationbar/>
            @endif
--}} -->
            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Site Administration') }}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb blurb="Tools for Site Administration"/>

                    </x-slot>

                    <x-slot name="table">
                        <div class=" flex flex-wrap space-x-2 space-y-1 align-top">

                            @livewire('siteadministration.siteadministrator')

                        </div>

                        <div>

                            <div name="coTeacherAssignment" style="margin: 0.5rem; border: 1px solid black;">

                                <form method="post" action="{{ route('siteadministration.coteacherassignment.store') }}" style="padding: 0.5rem;">

                                    @csrf

                                    @if(session()->has('coteacherassignments'))
                                        <div style="background-color: rgba(0,255,0,0.1); color: black; border: 1px solid darkgreen;">
                                            {{ session()->get('coteacherassignments') }}
                                        </div>
                                    @endif
                                    <h3 style="font-weight: bold;">
                                        Co-Teacher Assignment
                                    </h3>
                                    <h4>
                                        CoAssign current students of Teacher 1 to Teacher 2
                                    </h4>

                                    {{-- Teacher 1 --}}
                                    <style>
                                        .input-group{margin-bottom: 1rem;}
                                    </style>
                                    <div class="input-group">
                                        <label>Teacher 1</label>
                                        <select name="user_ids[]" style="width: 25rem;">
                                            <option value="0">Select</option>
                                            @foreach($teachers AS $teacher)
                                                <option value="{{ $teacher->user_id }}">{{ $teacher->last.', '.$teacher->first.' '.$teacher->middle.' ('.$teacher->user_id.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Teacher 2 --}}
                                    <div class="input-group">
                                        <label>Teacher 2</label>
                                        <select name="user_ids[]" style="width: 25rem;">
                                            <option value="0">Select</option>
                                            @foreach($teachers AS $teacher)
                                                <option value="{{ $teacher->user_id }}">{{ $teacher->last.', '.$teacher->first.' '.$teacher->middle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-group">
                                        <label></label>
                                        <input type="submit" name="submit" value="Submit">
                                    </div>

                                </form>
                            </div>

                            <a href="{{ route('siteadministrator.emailsdump') }}">
                                <button style="background-color: yellow; color: darkblue; padding: 0 0.5rem;">
                                    Subscriber Email dumps
                                </button>
                            </a>
                        </div>

                        <div>
                            <a href="{{ route('siteadministrator.emailsdump',['offset' => 1,'length'=> 3000]) }}">
                                <button style="background-color: yellow; color: darkblue; padding: 0 0.5rem;">
                                    NonSubscriber Email dumps 1-3000
                                </button>
                            </a>
                        </div>

                        <div>
                            <a href="{{ route('siteadministrator.emailsdump',['offset' => 3001,'length'=> 3000]) }}">
                                <button style="background-color: yellow; color: darkblue; padding: 0 0.5rem;">
                                    NonSubscriber Email dumps 3001-6000
                                </button>
                            </a>
                        </div>

                        <div>
                            <a href="{{ route('siteadministrator.emailsdump',['offset' => 6001,'length'=> 3000]) }}">
                                <button style="background-color: yellow; color: darkblue; padding: 0 0.5rem;">
                                    NonSubscriber Email dumps 6001-9000
                                </button>
                            </a>
                        </div>

                        <div>
                            <a href="{{ route('siteadministrator.emailsdump',['offset' => 9001,'length'=> 3000]) }}">
                                <button style="background-color: yellow; color: darkblue; padding: 0 0.5rem;">
                                    NonSubscriber Email dumps 9001-12000 (or end)
                                </button>
                            </a>
                        </div>


                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

            <div class="bg-white" style="min-width: 25rem; padding: 0.5rem;">
                <header style="margin-top: 1rem; border-bottom: 1px solid darkgrey; font-weight: bold;">
                    Stats
                </header>
                <div>
                    PHP Version: {{ phpversion() }}
                </div>
                <div>
                    Laravel Version: 8.83.6 (as of 01-Jun-22)
                </div>
            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
