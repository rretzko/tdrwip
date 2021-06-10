<div>
    <table class="table-auto overflow-scroll">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="sr-only px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
                Checkbox
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
                Asset
            </th>
            <th scope="col"
                 class="sr-only px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-12rem"
            >
                Message
            </th>
        </tr>
        </thead>
        <tbody>

        @forelse($assets AS $asset)

            <tr class="@if($loop->iteration % 2) bg-yellow-100 @else bg-white @endif">
                <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 align-text-top">

                    <input wire:model="assettypes"
                           type="checkbox"
                           name="assets[{{ $asset->id }}]"
                           value="{{ $asset->id }}"
                           {{ $ensembleassets->contains($asset) ? 'CHECKED' : '' }}
                    />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-left">
                    {{ ucwords($asset->descr) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 align-text-top text-left">
                </td>
            </tr>
        @empty
            <tr><td colspan="3">No assets found</td></tr>
        @endforelse

        </tbody>
    </table>

    <div>{{ $mssg }}</div>
</div>
