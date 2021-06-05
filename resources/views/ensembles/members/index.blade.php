<x-app-layout>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <x-table-with-modal-form >

                <x-slot name="title" >
                    {{ __('Ensemble Member Roster') }}
                </x-slot>

                <x-slot name="description" >

{!! __('Add or edit your ensemble membership roster here.<br />
<ul class="ml-5 list-disc text-white text-sm" >
<li>Click the number under the "Members" column to add/edit ensemble membership.</li>
<li>Ensemble names are unique to you and your school.  Please do not delete ensembles which have members assigned.</li>
<li>If necessary, deleted Ensembles can be reinstated by contacting
<a style="color: yellow" href="mailto:support@thedirectorsroom.com?subject=Ensemble reinstatement&body=Hi, I may need an ensemble name reinstated...">
Support
</a>.
</li>
</ul>') !!}

</x-slot>

<x-slot name="table">
    {{-- HEADER --}}
    <div id="membershipHeader">
        <h3 class="font-bold">{{ $ensemble->name }} Membership Roster</h3>
    </div>
    <div id="schoolYear" class="flex">
        <label for="schoolyear_id" class="h-8 pt-2">School Year: </label>
        <select name="schoolyear_id" id="schoolyear_id" class="h-8 ml-2 text-sm">
            @foreach($schoolyears AS $schoolyear_obj)
                <option value="{{ $schoolyear_obj->id }}" class="text-xs">{{ $schoolyear_obj->descr }}</option>
            @endforeach
        </select>
    </div>

{{-- ADD button --}}
<div class="flex justify-end mb-2 pr-6">
    <div
        class="bg-green-200 px-1 shadow-lg border border-green-600 rounded-md text-center cursor-pointer"
        style="max-width: 4rem;"
    >
        <a href="{{ route('ensemble.members.create', ['ensemble' => $ensemble, 'schoolyear' => $schoolyear]) }}"
            class="text-green-800">Add</a>
    </div>

</div>

<div class="overflow-x-auto">
    <table class="table-auto overflow-scroll">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Name
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Voice Part
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    <span class="sr-only">Edit</span>
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    <span class="sr-only">Delete</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($ensemble->members($schoolyear) AS $ensemblemember)

                <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                    <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 align-text-top">
                        {{ $ensemblemember->person->fullName }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                        {{ $ensemblemember->instrumentation->formattedDescr() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                        <a
                            href="{{ route('ensemble.members.edit',['ensemblemember' => $ensemblemember]) }}"
                            class="border border-blue-500 rounded px-2 bg-blue-400 text-white hover:bg-blue-600"
                        >
                            Edit
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-center">
                        <a
                            href="{{ route('ensemble.members.destroy') }}"
                            class="border border-red-500 rounded px-2 bg-red-400 text-white hover:bg-red-600"
                            onclick="return chickenTest({{$ensemblemember}});"
                        >
                            Delete
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No members found</td></tr>
            @endforelse
        </tbody>
    </table>
    <script>
        function chickenTest($object)
        {
            return confirm('Do you really want to delete the member?');
        }
    </script>
</div>
</x-slot>

</x-table-with-modal-form>

<x-jet-section-border />

</div>

</x-app-layout>
