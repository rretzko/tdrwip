<div>
    <x-table-form-section submit="updateProfileInformation">

        <x-slot name="title">
            {{ __('School and Studio Information') }}
        </x-slot>

        <x-slot name="description" >

            {{ __('Add or edit your school information here.') }}

            <br />
            {{ __('Note also that a Studio has been created for you to store information which may not be aligned to any
                    particular school or may be related to your personal studio.') }}

        </x-slot>

        <x-slot name="table">
            <!-- Studio + Schools table -->
            <!-- beginning of tailwindui table -->
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 "> <!--  -->
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach($table_headers AS $header)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $header }}
                                            </th>
                                    @endforeach
                            </thead>
                            <tbody>

                                @foreach($this->table_studios AS $studio)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $studio->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {!!  $studio->mailingAddress !!}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ $studio->years }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium ">
                                            <a href="{{ route('studio.show',['studio' => $studio]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach

                                @forelse($this->table_schools AS $school)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $school->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                              $school->mailingAddress
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                             $school->years
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium ">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-gray-200">
                                        <td colspan="4" class="text-center">No schools found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name="form">
            <h5 class="text-red-400">form goes here</h5>
        </x-slot>

        <x-slot name="actions">

            @if(session('success'))
                <x-success-message :success='session("success")' />
            @endif

            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>

    </x-table-form-section>
</div>
