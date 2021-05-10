@props([
'displayhide',
])
<div class="">
    <!-- PAGE DEFINITION HEADER -->
    <div class="flex justify-between "><!-- ml-4 mt-4 bg-white  -->
        <div class="text-lg leading-6 font-medium text-gray-900">
            Students <i>(def.)</i>
        </div>

        <div class=" flex flex-shrink-0 ">
            <!-- Heroicons small arrow-narrow-up -->
            <button type="button" wire:click="$toggle('displayhide')"
                    class="text-gray-500 text-sm px-2 focus:outline-none ">
                @if($displayhide) Hide @else Display @endif
            </button>
        </div>

    </div>

    <div x-data="{show: @if($displayhide) true @else false @endif }">
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
