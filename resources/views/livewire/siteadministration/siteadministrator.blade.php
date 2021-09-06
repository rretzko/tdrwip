<div class="mt-4 border-black p-1">

    <x-siteadministration.searchusers :persons="$persons" />
<!-- {{--
    <x-siteadministration.transfercurrentstudents
        :schools="$schools"
        selectedschoolname="{{ $selectedschoolname }}"
        :students="$students"
        :teachers="$teachers"
        />
--}} -->
    <div>
        <span class="bg-black text-white rounded px-1" wire:click="transferStudents" >Workaround</span>
    </div>
        <!-- {{-- :selectedschool="$selectedschool"



    /> --}} -->


</div>
