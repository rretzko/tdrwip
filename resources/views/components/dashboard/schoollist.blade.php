@props([
'dashboard'
])
<div class="border border-black">
    <div class="bg-gray-200 border border-black text-center font-bold">
        Schools
    </div>
    {!! $dashboard->schoolsUl !!}
</div>
