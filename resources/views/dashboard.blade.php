<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            @if($teachers->count())
                <x-impersonationbar/>
            @endif

            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Dashboard') }}:{{config('app_env')}}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb blurb="The Dashboard will contain various tabular, graphic and linked data
                            for your general use."/>

                        @if($gettingstarted)
                            <x-dashboard.gettingstarted />
                        @else
                            <div>
                                <input type="checkbox"
                            </div>
                        @endif



                    </x-slot>

                    <x-slot name="table">
                        <div class=" flex flex-wrap space-x-2 space-y-1 align-top">
                            <style>
                                .dashboardcard{}
                                .dashboardcard header{background-color: lightgray; border: 1px solid black;text-align: center;font-weight: bold;}
                                .dashboardcard .dashboardbody{border: 1px solid black; padding:0 .25rem;}
                            </style>
                            <x-dashboard.countstudents :dashboard="$dashboard" />
                            <x-dashboard.schoollist :dashboard="$dashboard" />
                            <x-dashboard.orientation />
                            <x-dashboard.eventversiondocs />

                        </div>
                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
