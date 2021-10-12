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

    <div class="my-3">
        <span class="bg-black text-white rounded px-1" wire:click="transferStudents" >Workaround</span>
    </div>

    <div class="mt-1">
        <a href="{{ route('siteadministration.teachertable.index') }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">TeachersTable</a>
    </div>


</div>
