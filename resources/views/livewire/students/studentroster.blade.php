<div>
    <div class="bg-white w-10/12 mx-auto border rounded p-2 mb-2">
        <div class="">
            <!-- PAGE DEFINITION HEADER -->
            <div class="flex justify-between "><!-- ml-4 mt-4 bg-white  -->
                <div class="text-lg leading-6 font-medium text-gray-900">
                    Students <i>(def.)</i>
                </div>
                <div class=" flex flex-shrink-0 ">
                    <!-- Heroicons small arrow-narrow-up -->
                    <button type="button" wire:click="$toggle('display_hide')"
                            class="text-gray-500 text-sm px-2 focus:outline-none ">
                        <!--  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 -->
                        {{ $display_hide ? 'Hide' : 'Display' }}
                    </button>
                </div>
            </div>

            <!-- PAGE DEFINITION DETAIL -->
            <div x-data="{show: @if($display_hide) true @else false @endif }">
                <div class=""
                     x-show.transition.duration.300ms.="show"
                >
                    <p class="mt-1 text-sm text-gray-500">
                        The Students page displays your roster of students, both past and present.
                    </p>
                    <p class="mt-1 text-sm text-gray-500">
                        Click on any student's name to display their detailed information.
                    </p>
                </div>
            </div>
        </div>
    </div> <!-- END OF PAGE DEFINITION -->

    <!-- PAGE TABLE -->
    <x-studentroster.multi-column-directory  countstudents={{$countstudents}} :schools='$schools' />

    <div class="flex flex-col px-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 ">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students AS $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{$student->person->fullNameAlpha}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                jane.cooper@example.com
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                    <div class="text-sm text-gray-500">Optimization</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Active
                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Admin
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No students found</td></tr>
                        @endforelse

                        <!-- More items... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
