@props([
'id'
])
<div
    class="bg-gray-500 px-0.5 shadow-lg border border-black rounded-md text-center cursor-pointer h-5 pl-1"
    style="max-width: 2rem;"
    title="Delete this?"
    wire:click="delete({{ $id }})"
>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20px" title="Delete this?" fill="#C0C0C0">
        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
</div>
