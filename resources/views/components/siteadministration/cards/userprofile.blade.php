@props([
'person'
])
<style>
    label{margin-right: 1rem;}
    .card-row{display: flex;}
    .data{font-weight: bold;}
</style>
<div class="flex flex-col border border-black mb-2 p-1">
    <div class="card-row">
        <label>Sys.Id.</label>
        <div class="data">{{ $person->user_id }}</div>
    </div>

    <div class="card-row">
        <label>Name</label>
        <div class="data">{{ $person->fullName }}</div >
    </div>

    <div class="card-row">
        <label>Status</label>
        <div class="data">
            @if($person->user->isTeacher())Teacher
            @elseif($person->user->isStudent())Student
            @else
                Other
            @endif
        </div>
    </div>
</div>
