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
    <x-studentroster.school-selector :schools="$schools" schoolid={{$schoolid}}/>
    <x-studentroster.multi-column-directory  countstudents={{$countstudents}} :schools='$schools' :search='$search' :filter='$filter'/>
    <div class="{{$displayform ? 'flex' : ''}} w-12/12">
        <x-studentroster.table :students='$students' :displayform='$displayform' />
        <x-studentroster.form :displayform="$displayform" :pronouns="$pronouns" :heights="$heights" :shirtsizes="$shirtsizes" :student="$student"  />
    </div>

</div>


