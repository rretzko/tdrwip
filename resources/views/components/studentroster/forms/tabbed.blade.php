@props([
'choralinstrumentation',
'classofs',
'displayform',
'geostates',
'heights',
'instrumentalinstrumentation',
'instrumentationbranch_id',
'instrumentationbranches',
'newinstrumentations',
'photo',
'pronouns',
'shirtsizes',
'student',
'tab' => 'biography',
'tabcontent' => false,
])
<div
    class="{{$displayform ? 'w-full md:w-6/12 lg:w-8/12 bg-blue-50 text-black border border border-black border-l-3 border-t-0 border-r-0 px-3' : 'hidden'}}"
>
    <div class="flex justify-end text-xs pt-2 pr-3 ">
        <a href="#" wire:click="$set('displayform',0)" class="text-blue-700">Return to Students table</a>
    </div>

    @if((! is_null($student)) && $student->user_id)

        {{-- NAVIGATION TABS --}}
        <x-studentroster.forms.tabs :tab="$tab" :student="$student" />

        {{-- FORMS DISPLAY LOGIC --}}
        @if($tab === 'biography')
            <x-studentroster.forms.sections.biography :student="$student" :photo="$photo" />
        @elseif($tab === 'profile')
            <x-studentroster.forms.sections.profile
                :classofs="$classofs"
                :heights="$heights"
                :pronouns="$pronouns"
                :shirtsizes="$shirtsizes"
                :student="$student"
            />
        @elseif($tab === 'instrumentation')
            <x-studentroster.forms.sections.instrumentation
                :choralinstrumentation="$choralinstrumentation"
                :instrumentalinstrumentation="$instrumentalinstrumentation"
                :student="$student"
            />
        @elseif($tab === 'communication')
            <x-studentroster.forms.sections.communication
                :student="$student"
            />
        @elseif($tab === 'homeaddress')
            <x-studentroster.forms.sections.homeaddress
                :geostates="$geostates"
                :student="$student"
            />
        @elseif($tab === 'guardian')
            <x-studentroster.forms.sections.guardian
                :student="$student"
            />
        @else
            Some other tab: {{$tab}} section here...
        @endif
    @else {{-- NEW STUDENT --}}

        {{-- NAVIGATION TABS --}}
        <x-studentroster.forms.tabs :tab="$tab" :student="$student" />

        <x-studentroster.forms.sections.profile
            :classofs="$classofs"
            :heights="$heights"
            :pronouns="$pronouns"
            :shirtsizes="$shirtsizes"
            :student="$student"
        />

    @endif
</div>

