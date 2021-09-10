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
    <x-siteadministration.loginas :loginas="$loginas" />

    <x-siteadministration.resetpassword :users="$users"/>

    <div class="mt-1">
        <span class="bg-black text-white rounded px-1" wire:click="transferStudents" >Workaround</span>
    </div>
        <!-- {{-- :selectedschool="$selectedschool"



    /> --}} -->


</div>
