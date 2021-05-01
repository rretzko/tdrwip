<div class="m-auto" style="max-width: 1024px;">
    <div class="w-10/12 mx-auto border rounded p-2 mb-2 bg-yellow-50" >
        <!-- PAGE DEFINITION DETAIL -->
        <x-studentroster.pagedef displayhide="{{$displayhide}}" />
    </div>

    <!-- TABLE SECTION HEADERS -->
    <x-studentroster.multi-column-directory  countstudents={{$countstudents}} :schools='$schools' :search='$search' :filter='$filter'/>

    <!-- PAGE TABLE AND [STUDENT DATA FORM] -->
    <div class="{{$displayform ? 'flex' : ''}} w-12/12">
        {{-- COLLAPSING TABLE --}}
        <x-studentroster.table :students="$students" :displayform="$displayform" :teacher="$teacher" />

        {{-- STUDENT DETAILED INFORMATION TABBED --}}
        <x-studentroster.forms.tabbed
            :classofs="$classofs"
            :displayform="$displayform"
            :heights="$heights"
            :student="$student"
            :photo="$photo"
            :pronouns="$pronouns"
            :shirtsizes="$shirtsizes"
            :tabcontent="$tabcontent"
            :tab="$tab"
        />

        <!-- :addinstrument="$addinstrument"
        :choralinstrumentation="$choralinstrumentation"
        :geostates="$geostates"
        :guardians="$guardians"
        :instrumentationbranch_id="$instrumentationbranch_id"
        :instrumentalinstrumentation="$instrumentalinstrumentation"
        :instrumentationbranches="$instrumentationbranches"
        :newinstrumentations="$newinstrumentations"
        :showmodalremoveguardian="$showmodalremoveguardian"
        -->

    </div>

</div>
