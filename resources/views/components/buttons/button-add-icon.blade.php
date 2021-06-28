@props([
'toggle'
])
<div
    wire:click="$set('{{ $toggle }}', 'true')"
    class="bg-green-200 px-0.5 shadow-lg border border-green-600 rounded-md text-center cursor-pointer" style="max-width: 4rem;"
    title="Add new?"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
</div>
