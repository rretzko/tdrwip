<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            @if($teachers->count())
                <x-impersonationbar/>
            @endif

            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Dashboard') }}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb blurb="The Dashboard will contain various tabular, graphic and linked data
                            for your general use."/>

                        @if($gettingstarted)
                            <x-dashboard.gettingstarted />
                        @endif



                    </x-slot>

                    <style>
                        .statbox{border: 1px solid black;margin-left: 1rem;}
                        .statboxheader{background-color: lightgrey; border: 1px solid black;}
                        ul{margin-left: 1rem; list-style-type: disc;}
                    </style>
                    <x-slot name="table">
                        <div class=" flex flex-wrap space-x-2">
                            <x-dashboard.countstudents :dashboard="$dashboard" />
                            <x-dashboard.schoollist :dashboard="$dashboard" />
                            <x-dashboard.orientation />

                        </div>
                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
