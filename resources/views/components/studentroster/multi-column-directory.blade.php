@props([
    'countstudents',
    'temp',
    'search',
])
<div class="mx-4"><!-- flex bg-green-200 -->
    <div class="bg-white "><!-- flex flex-col order-first flex flex-col flex-shrink-0 border-r border-gray-200 -->

        <div class="px-2 space-y-2"><!-- mx-4 px-4 pt-2 pb-2 bg-yellow-200  -->

            <!-- text-lg font-medium text-gray-900 -ml-6  -->
            <p class=" text-sm text-gray-600 pt-2">
                Search directory of {{ $countstudents }} student{{ ($countstudents > 1) ? 's' : '' }}
            </p>

            <form class="mt-6 flex" action="#">
                <div class="flex-1 min-w-0 ">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

                            <!-- Heroicon name: magnifying glass solid/search -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input wire:model="search" type="search" name="search" id="search"
                               class="focus:ring-pink-500 focus:border-pink-500 block w-3/12 pl-10 sm:text-sm border-gray-300 rounded-md"
                               placeholder="Search Students">
                    </div>

                </div>
                <button type="submit"
                        class="inline-flex  px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <!-- Heroicon name: solid/filter -->
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
        </div>

        <!-- Tab segments -->
        <div>

            <div class="block">
                <div class="border-b border-gray-200">
                    <nav class="flex justify-around space-x-8 mx-4" aria-label="Tabs">
                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                        <a href="#"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                            <!--
                              Heroicon name: solid/user

                              Current: "text-indigo-500", Default: "text-gray-400 group-hover:text-gray-500"
                             -->
                            <svg class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Current</span>
                        </a>

                        <a href="#"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                            <!-- Heroicon name: solid/office-building -->
                            <svg class="text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Alum</span>
                        </a>

                        <a href="#"
                           class="border-indigo-500 text-indigo-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm"
                           aria-current="page">
                            <!-- Heroicon name: solid/users -->
                            <svg class="text-indigo-500 -ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>All</span>
                        </a>

                    </nav>
                </div>
            </div>
        </div>

        <!-- Directory Table -->
        <!-- {{--
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
        --}} -->

        <!-- Directory list -->
<!-- {{--
        <nav class="flex-1 min-h-0 overflow-y-auto" aria-label="Directory">
            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>A</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    @forelse($students AS $student)
                        <li>
                            <div
                                class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                         src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{$student->person->fullNameAlpha}}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            Co-Founder / CEO
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>No students found</li>
                    @endforelse
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Leslie Abbott
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Co-Founder / CEO
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Hector Adams
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        VP, Marketing
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Blake Alexander
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Account Coordinator
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Fabricio Andrews
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Senior Art Director
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>B</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1501031170107-cfd33f0cbdcc?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Angela Beaver
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Chief Strategy Officer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1506980595904-70325b7fdd90?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Yvette Blanchard
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Studio Artist
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1513910367299-bce8d8a0ebf6?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Lawrence Brooks
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Content Specialist
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>C</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Jeffrey Clark
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Senior Art Director
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Kathryn Cooper
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Associate Creative Director
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>E</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1509783236416-c9ad59bae472?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Alicia Edwards
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Junior Copywriter
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Benjamin Emerson
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Director, Print Operations
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1504703395950-b89145a5425b?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Jillian Erics
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Designer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Chelsea Evans
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Human Resources Manager
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>G</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Michael Gillard
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Co-Founder / CTO
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Dries Giuessepe
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Manager, Business Relations
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>M</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1507101105822-7472b28e22ac?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Jenny Harrison
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Studio Artist
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Lindsay Hatley
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Front-end Developer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Anna Hill
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Partner, Creative
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>S</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Courtney Samuels
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Designer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Tom Simpson
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Director, Product Development
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>T</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Floyd Thompson
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Principal Designer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Leonard Timmons
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Senior Designer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Whitney Trudeau
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Copywriter
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>W</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Kristin Watson
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        VP, Human Resources
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Emily Wilson
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        VP, User Experience
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="relative">
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>Y</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li>
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-1.2.1&ixqx=tD9sDKeYHB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        Emma Young
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Senior Front-end Developer
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
--}} -->
    </div>
</div>
