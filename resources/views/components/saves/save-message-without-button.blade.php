@props([
'message' => 'Saved',
'trigger' => 'saved-biography',
])
<div class="font-italic bg-green-200 p-2"
     x-data="{show: false}"
     x-show.transition.duration.500ms="show"
     x-init="@this.on('{{$trigger}}',() => {
        setTimeout(() => { show = false; }, 2500 );
        show = true;
        })"
>
    {{$message}}
</div>
