@props([
'displayform',
'student' => false,
])
<!--'addinstrument',
'choralinstrumentation',
'classofs',

'footinches',
'geostates',
'guardian',
'guardianfullname',
'guardians',
'heights',
'instrumentalinstrumentation',
'instrumentationbranch_id',
'instrumentationbranches',
'newinstrumentations',
'photo',
'pronouns',
'shirtsizes',
'showmodalremoveguardian' => false,
-->


<div
    class="{{$displayform ? 'w-8/12 -ml-4 bg-blue-50 text-black border border border-black border-l-3 border-t-0 border-r-0 px-3' : 'hidden'}}">

    @if($student)
        <x-studentroster.forms.tabs />
        <div>
            tab row<br />
            form
        </div>
    @endif
</div>

