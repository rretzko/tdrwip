<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ensembles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="p-2 font-bold">Ensembles</h1>

                <ul>
                    <li>
                        <form method="post" action="{{ route('ensemble.store') }}" class="flex flex-col">
                            @csrf
                            <div class="flex flex-col px-4 mb-3">
                                <label for="name">Ensemble name</label>
                                <input type="text" name="name" placeholder="Add an ensemble..." required />
                            </div>

                            <div class="flex flex-col px-4 mb-3">
                                <label for="abbr">Abbreviation</label>
                                <input type="text"  name="abbr" required />
                            </div>

                            <div class="flex flex-col px-4 mb-3">
                                <label for="descr">Description</label>
                                <textarea row="3" cols="40" placeholder="Describe the ensemble"></textarea>
                            </div>

                        </form>
                    </li>

                    @foreach($ensembles AS $ensemble)
                        <li>
                            <a href="/dev/feature_ensembles/public/ensemble/{{ $ensemble->id }}">{{ $ensemble->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</x-app-layout>
