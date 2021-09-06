<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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
                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
