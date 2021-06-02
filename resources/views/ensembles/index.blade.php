<x-app-layout>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <x-table-with-modal-form >

                <x-slot name="title">
                    {{ __('Ensemble Information') }}
                </x-slot>

                <x-slot name="description" >

                    {{ __('Add or edit your ensemble information here.') }}

                </x-slot>

                <x-slot name="table">
                    {{-- Studio + Schools table --}}
                    {{-- ADD button --}}
                    <div class="flex justify-end mb-2 pr-6">
                        <div
                            class="bg-green-200 px-1 shadow-lg border border-green-600 rounded-md text-center cursor-pointer"
                            style="max-width: 4rem;"
                        >
                            <a href="{{ route('ensemble.create') }}"
                                class="text-green-800">Add</a>
                        </div>

                    </div>

                    <div>
                        <table class="min-w-full divide-y divide-gray-200 divide-y">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-center tex-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center tex-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Type
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center tex-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Since
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center tex-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Edit
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center tex-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ensembles AS $object)
                                    <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top">
                                            {{ $object->name }} ({{$object->abbr}})
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                                            {{ $object->ensembletype->descr }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                                            {{ $object->startyear }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                                            <a
                                                href="{{ route('ensemble.edit', ['ensemble' => $object]) }}"
                                                class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                                            >Edit</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                                            Delete
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-slot>

            </x-table-with-modal-form>

            <x-jet-section-border />

        </div>

</x-app-layout>
