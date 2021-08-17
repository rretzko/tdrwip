<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Membership Card') }}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb blurb="Record your membership information here for {{ $organization->name }}." />

                        <x-sidebar-blurb blurb="This membership card will also display for: {!! $ancestors !!}"/>

                    </x-slot>




                    <x-slot name="table">

                        {{-- BACK TO ROSTER --}}
                        <div class="flex text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 20 20"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <a href="{{ route('organizations.index') }}"
                               class="text-red-700 ml-2 pb-4">
                                Return to Organization Roster
                            </a>
                        </div>

                        {{-- MEMBERSHIP CARD FORM --}}
                        <div class="overflow-x-auto lg:w-6/12 md:w-8/12 w-11/12 ">

                            <form method="post" action="{{ ($membership && $membership->id)
                                ? route('organization.membershipcard.update', ['membership' => $membership])
                                : route('organization.membershipcard.create')}}"
                                  enctype="multipart/form-data"
                            >

                                @csrf

                                {{-- MEMBERSHIP TYPE --}}
                                <x-inputs.group label="Membership type" for="membershiptype_id">

                                    <x-inputs.select
                                        label="Membership type"
                                        for="membershiptype_id"
                                        :options=$membershiptypes
                                    />

                                </x-inputs.group>

                                {{-- MEMBERSHIP ID --}}
                                <x-inputs.group label="Membership id" for="membershiptype_id" borderless="true" paddingless="true">

                                    <x-inputs.text
                                        label=""
                                        for="membershiptype_id"

                                    />

                                </x-inputs.group>

                                {{-- EXPIRATION --}}
                                <x-inputs.group label="Expiration date" for="expiration" borderless="true" paddingless="true">

                                    <x-inputs.date
                                        label=""
                                        for="expiration"
                                    />

                                </x-inputs.group>

                                {{-- GRADE LEVELS --}}
                                <x-inputs.group label="Grade levels" for="grade_levels" borderless="true" paddingless="true">

                                    <x-inputs.text
                                        label=""
                                        for="grade_levels"
                                        placeholder="Secondary, middle, elementary"
                                    />

                                </x-inputs.group>

                                {{-- SUBJECTS --}}
                                <x-inputs.group label="Subjects" for="subject" borderless="true" paddingless="true">

                                    <x-inputs.text
                                        label=""
                                        for="subject"
                                        placeholder="Chorus, General Music"
                                    />

                                </x-inputs.group>

                                {{-- MEMBERSHIP CARD --}}
                                <x-inputs.group label="Membership card" for="membershipcard" borderless="true" paddingless="true">

                                    <input type="file" name="membershipcard">

                                </x-inputs.group>

                                <x-inputs.group for="submit" label="" borderless="true" >
                                    <x-buttons.button-save />
                                </x-inputs.group>
                            </form>
                        </div>

                    </x-slot>

                </x-livewire-table-with-modal-forms>

            </div>

        </div>
    </div>

    <x-jet-section-border />

</x-app-layout>
