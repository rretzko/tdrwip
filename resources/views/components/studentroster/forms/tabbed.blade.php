@props([
'choralinstrumentation',
'classofs',
'displayform',
'heights',
'instrumentalinstrumentation',
'instrumentationbranch_id',
'instrumentationbranches',
'newinstrumentations',
'photo',
'pronouns',
'shirtsizes',
'student' => false,
'tab' => 'biography',
'tabcontent' => false,
])
<!--'addinstrument',
'footinches',
'geostates',
'guardian',
'guardianfullname',
'guardians',
'showmodalremoveguardian' => false,
-->
<div
    class="{{$displayform ? 'w-8/12 -ml-4 bg-blue-50 text-black border border border-black border-l-3 border-t-0 border-r-0 px-3' : 'hidden'}}">

    @if($student)
        <x-studentroster.forms.tabs :tab="$tab" />
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
        @else
            Some other tab: {{$tab}} section here...
        @endif
    @endif
</div>

