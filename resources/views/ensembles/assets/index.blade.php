<x-app-layout>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <x-table-with-modal-form >

                <x-slot name="title" >
                    {{ __('Ensemble Asset types') }}
                </x-slot>

                <x-slot name="description" >

                    {!! __('Add or edit your ensemble asset here.<br/>
                            Ensemble assets are anything which you assign to an ensemble member.<br/>
                            Click any checkbox to add an asset type to <b>'.$ensemble->name.'</b> for
                            <b>'.$schoolyear->descr.'</b>.<br/>
                            Once an asset type is added, you will be able to create a catalog for all assets assigned to
                            each <b>'.$ensemble->name.'</b> member.<br />
                            Click the "Add" button to add a new asset type to the list.') !!}

                </x-slot>

                <x-slot name="table">
                    {{-- HEADER --}}
                    <div id="assetHeader">
                        <h3 class="font-bold">{{ $ensemble->name }} Asset Types</h3>
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
                        <a href="{{ route('ensemble.assets.create', ['ensemble' => $ensemble, 'schoolyear' => $schoolyear]) }}"
                            class="text-green-800">Add</a>
                    </div>

                </div>

                <div class="overflow-x-auto">

                    @livewire('ensembles.assets-table')

                </div>
            </x-slot>

</x-table-with-modal-form>

<x-jet-section-border />

</div>

</x-app-layout>
