@props([
    'displayform',
    'students'
])
<div class="{{$displayform ? 'w-4/12' : 'flex flex-col'}} px-4">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 ">
                <table class="min-w-full divide-y divide-gray-200 ">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name<br />{{$displayform ? '' : "Class | B'day | Height | Shirt Size"}}
                        </th>
                        <th scope="col" class="{{$displayform ? 'hidden' : 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'}}">
                            Contact
                        </th>
                        <th scope="col" class="{{$displayform ? 'hidden' : 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'}}">
                            Status
                        </th>
                        <th scope="col" class="{{$displayform ? 'hidden' : 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'}}">
                            Role
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                    @forelse($students AS $student)
                        <tr class="{{ ($loop->iteration % 2) ? 'bg-yellow-50' : '' }} ">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($student->person->user->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full"
                                                 src="{{ '/storage/'.substr($student->person->user->profile_photo_path,7) }}"
                                                 alt="Profile image">
                                        @else
                                            <svg class='h-full w-full text-gray-300 rounded-full' fill='currentColor'
                                                 viewBox='0 0 24 24'>
                                                <path
                                                    d='M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z'/>
                                            </svg>
                                        @endif

                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{$student->person->fullNameAlpha.' ('.$student->user_id.')' ?? 'null_object'}}
                                        </div>
                                        <div class="{{$displayform ? 'hidden' : 'text-sm text-gray-500'}}">
                                            {{$student->classof}} ({{$student->grade}}) | {{$student->fbirthday}} |  {{$student->heightFootInch}} | {{$student->shirtsize->descr}}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="{{$displayform ? 'hidden' : ' px-6 py-4 whitespace-nowrap'}}">
                                @if($student->emailPersonal->id)
                                    <div class="text-sm">
                                        <a class="text-blue-700"
                                           href="mailto:{{$student->emailPersonal->email}}?subject=From {{auth()->user()->person->honorificDescr}} {{auth()->user()->person->last}}&body=Hi, {{$student->person->first}}"
                                        >
                                            {{$student->emailPersonal->email}}</a>
                                    </div>
                                @endif

                                <div class="text-sm">
                                    <a
                                        class="text-blue-700"
                                        href="mailto:{{$student->emailSchool->email}}?subject=From {{auth()->user()->person->honorificDescr}} {{auth()->user()->person->last}}&body=Hi, {{$student->person->first}}"
                                    >
                                        {{$student->emailSchool->email}}
                                    </a>
                                </div>

                                <div class="text-sm text-gray-500">{{$student->phoneMobile->id ? $student->phoneMobile->phone : '' }} @if($student->phoneMobile->id)(c) @endif</div>
                                <div class="text-sm text-gray-500">{{$student->phoneHome->id ? $student->phoneHome->phone : '' }} @if($student->phoneHome->id)(h) @endif</div>
                            </td>
                            <td class="{{$displayform ? 'hidden' : 'px-6 py-4 whitespace-nowrap'}}">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student->status === 'alum' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                  {{ $student->status }}
                                </span>
                            </td>
                            <td class="{{$displayform ? 'hidden' : 'px-6 py-4 whitespace-nowrap text-sm text-gray-500'}}">
                                Admin
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" wire:click="studentForm({{$student->user_id}})" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{$displayform ? '2' : '5'}}" class="text-center text-gray-500">No students found {{$students->count()}}</td></tr>
                    @endforelse

                    <!-- More items... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
