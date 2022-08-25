<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table {
            margin: auto;
            margin-bottom: 1rem;
            width: 96%;
            font-size: .8rem;
        }

        tr.sectionHeader {
            background-color: #cbd5e0;
            font-weight: bold;
            padding: 0 4px;
        }
        tr.sectionHeader th{
            padding-left: .5rem;
            text-align: left;
        }
        tr.sectionDescr td{
            font-size: 1rem;
            font-style: italic;
            text-align: justify;
            padding-left: .5rem;
            padding-right: .5rem;
        }
        tr.sectionSignatures td{
            padding-top: 1rem;
        }
        .pgbrk{page-break-after: always;}

    </style>
    <title></title>
</head>
<body style="border: 1px solid white; padding: 1rem; ">

{{-- PAGE HEADER --}}
<table>
    <tr>
        <td style="text-align: center; font-size: 1.5rem; font-weight: bold;">
            Morris Area Honor Choir - Middle and High School
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: 1.5rem;">
            {{ $eventversion->name }}
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: smaller;">
            <div>
                eApplications are accepted through:
                <span style="color: red; font-weight: bold;">{{ $eventversion->dates('signature_close') }}</span>.<br />
                All audio files must be submitted to your sponsoring Directors.<br />
                <p>
                    PLEASE NOTE: Should you be selected to participate in this Honor Choir,
                    masks will be mandatory for the duration of your experience.
                    Breaks will be provided throughout to ensure our time together is
                    comfortable and safe.
                </p>
            </div>
        </td>
    </tr>
</table>

{{-- STUDENT DETAIL DECLARATION --}}
<style>
    table.detailDeclaration {border-collapse: collapse; margin: auto; margin-bottom: 1rem;}
    table.detailDeclaration td.label{text-align:left; width: 20%; border: 0;}
    table.detailDeclaration td.data{text-align: left; font-weight: bold; border: 0;}
</style>
<table class="detailDeclaration">
    <tr>
        <td class="label">
            Student Name:
        </td>
        <td class="data">
            {{ $registrant->student->person->fullName }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Address:
        </td>
        <td class="data">
            {{ $registrant->student->person->user->address->addressCSv }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Height:
        </td>
        <td class="data">
            {{ $registrant->student->heightFootInch }}
        </td>
    </tr>
    <tr>
        <td class="label" style="padding-top: .5rem;">
            Home Phone:
        </td>
        <td class="data" style="padding-top: .5rem;">
            {{ $registrant->student->phoneHome->id ? $registrant->student->phoneHome->phone : '' }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Cell Phone:
        </td>
        <td class="data">
            {{ $registrant->student->phoneMobile->id ? $registrant->student->phoneMobile->phone : '' }}
        </td>
    </tr>
    <tr>
        <td class="label" style="padding-top: .5rem;">
            Email Personal:
        </td>
        <td class="data" style="padding-top: .5rem;">
            {{ $registrant->student->emailPersonal->id ? $registrant->student->emailPersonal->email : '' }}
        </td>
    </tr>
    <tr>
        <td class="label" >
            Email School:
        </td>
        <td class="data" style="padding-top: .5rem;">
            {{ $registrant->student->emailSchool->id ? $registrant->student->emailSchool->email : '' }}
        </td>
    </tr>
</table>


{{-- EMERGENCY CONTACT --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="2">Emergency Contact Information</th>
    </tr>
    <tr>
        <td class="label">
            Parent Name:
        </td>
        <td class="data">
            {{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->person->fullName : '' }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Parent Phone:
        </td>
        <td class="data">
            {{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->phoneCsv : '' }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Parent Email:
        </td>
        <td class="data">
            {{ $registrant->student->guardians->count() ? $registrant->student->guardians->first()->emailCsv : '' }}
        </td>
    </tr>
</table>

{{-- CHORAL DIRECTOR INFORMATION --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="2">Choral Director Information</th>
    </tr>
    <tr>
        <td class="label">
            School:
        </td>
        <td class="data">
            {{ $school->name }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Choral Director:
        </td>
        <td class="data">
            {{ auth()->user()->person->fullName }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Phones:
        </td>
        <td class="data">
            {{ auth()->user()->person->subscriberPhoneCsv }}
        </td>
    </tr>
</table>

{{-- AUDITION INFORMATION --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="2">Audition Informtion</th>
    </tr>
    <tr>
        <td class="label">
            Grade:
        </td>
        <td class="data">
            {{ $registrant->student->gradeClassof }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Preferred Pronoun:
        </td>
        <td class="data">
            {{ $registrant->student->person->pronoun->descr }}
        </td>
    </tr>
    <tr>
        <td class="label">
            Voice Part:
        </td>
        <td class="data">
            {{ $registrant->instrumentations->first()->formattedDescr() }}
        </td>
    </tr>
</table>

{{-- PAYMENT RECORD  --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="2">Payment record</th>
    </tr>
    <tr>
        <td  colspan="2" style="margin-bottom: 0.5rem;">
            An audition fee of $10.00 per student will be charged.  In addition, chorus
            students accepted will be assessed a participation fee of $25.00.
            The music will be theirs to keep.
        </td>
    </tr>
    <tr>
        <td class="label">
            Payment Method:
        </td>
        <td class="data">
            {{ $eapplication->paymentmethod }}
        </td>
    </tr>
</table>

{{-- SCHEDULE  --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="3">Morris Area Honor Choir Schedule</th>
    </tr>
    <tr>
        <td  colspan="3" style="text-align: center; font-size: smaller;">
            ** All students will be given learning tracks and will be expected to learn their music before the first rehearsal. **
        </td>
    </tr>
    <tr>
        <td class="spacer" colspan="3" style="height: 0.5rem;"> </td>
    </tr>
    <tr>
        <td>Thursday, January 6th</td>
        <td>4:00 - 8:15pm</td>
        <td>Rehearsal</td>
    </tr>
    <tr>
        <td>Monday, January 10th</td>
        <td>4:00 - 8:15pm</td>
        <td>Rehearsal</td>

    </tr>
    <tr>
        <td>Tuesday, January 11th</td>
        <td>4:00 - 8:15pm</td>
        <td>SNOW DATE</td>
    </tr>
    <tr>
        <td>Wednesday, January 12th</td>
        <td>4:00 - 8:15pm</td>
        <td>Rehearsal</td>
    </tr>
    <tr>
        <td>Friday, January 14th</td>
        <td>9:00am - 3:00pm</td>
        <td>All-Day Rehearsal</td>
    </tr>
    <tr>
        <td>Saturday, January 15th</td>
        <td>10:00am - 1:00pm</td>
        <td>Rehearsal</td>
    </tr>
    <tr>
        <td class="spacer" colspan="3" style="height: 0.5rem;"> </td>
    </tr>
    <tr>
        <td>Saturday, January 15th</td>
        <td>1:00 pm</td>
        <td>Concert</td>
    </tr>
    <tr>
        <td>Sunday, January 16th</td>
        <td>1:00pm </td>
        <td>Call</td>
    </tr>
    <tr>
        <td>Sunday, January 16th</td>
        <td>4:00pm</td>
        <td>SNOW DATE</td>
    </tr>
</table>

{{-- PAGE BREAK --}}
<div class="pgbrk" style="text-align: center;magein-top: 2rem;">Page 1/2</div>

{{-- PAGE HEADER --}}
<table>
    <tr>
        <td style="text-align: center; font-size: 1.5rem; font-weight: bold;">
            Morris Area Honor Choir - Middle and High School
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: 1.5rem;">
            {{ $eventversion->name }}
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: smaller;">
            <div>
                eApplications are accepted through:
                <span style="color: red; font-weight: bold;">{{ $eventversion->dates('signature_close') }}</span>.<br />
                All audio files must be submitted to your sponsoring Directors.<br />
                <p>
                    PLEASE NOTE: Should you be selected to participate in this Honor Choir,
                    masks will be mandatory for the duration of your experience.
                    Breaks will be provided throughout to ensure our time together is
                    comfortable and safe.
                </p>
            </div>
        </td>
    </tr>
</table>

{{-- EXPECTATIONS AND POLICIES --}}
<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="3">Ensemble Expectations and Policies</th>
    </tr>
</table>
<div class="mb-4">
    <div class=" justify-self-stretch mx-4 mb-4">
        <ol style="margin-left: 1rem; list-style-type: decimal; font-size: smaller;">
            <li style="margin-bottom: 0.5rem;">
                Participants are required to attend all rehearsals and performances for their full duration.
            </li>
            <li style="margin-bottom: 0.5rem;">
                A single absence due to illness may be allowed, provided such absence
                is explained to the satisfaction of the student's director, who in
                turn will notify the chorus manager as to the nature of the absence.
                Absence for other extenuating circumstances of a serious nature,
                beyond the student's control, will be permitted provided the absence
                is approved by BOTH the student's school director and the chorus manager.
                In any event, only ONE evening absence for whatever reason may be
                excused. (If either the director or manager finds the absence unexcused,
                the student's membership will be terminated.)
            </li>
            <li style="margin-bottom: 0.5rem;">
                Any student who misses more than one evening rehearsal for ANY reason,
                or who misses the all-day rehearsal before the concert (Friday, January 10th)
                or rehearsal the morning of the concert (Saturday, January 11th) will
                not be allowed to participate.
            </li>
            <li style="margin-bottom: 0.5rem;">
                An audition fee of $10.00 per student will be charged.  In addition,
                chorus students accepted will be assessed a participation fee of $25.00.
                The music will be theirs to keep.
            </li>
        </ol>
    </div>
</div>

{{-- ENDORSEMENTS --}}

<table class="detailDeclaration">
    <tr class="sectionHeader">
        <th colspan="3">Endorsements</th>
    </tr>
</table>

<table>
    <tr>
        <td style="vertical-align: top;">
            Student Certification
        </td>
        <td>
            I certify that I will accept the decisions of the judges and
            conductors as binding and if selected will accept membership in this
            organization. I understand that membership in this organization will be terminated
            if I fail to perform satisfactorily within my own school group or if I
            fail to adhere to the rules set forth above.
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black;">Signature</td>
        <td style="border-bottom: 1px solid black; @if($eapplication->signaturestudent) font-style: italic; font-size: 1rem; font-weight: bold; @else color: darkgrey; @endif">
            @if($eapplication->signaturestudent){{ $registrant->student->person->fullname }}
                @else Unsigned
            @endif
        </td>
    </tr>
    <tr>
        <td style="vertical-align: top;">
            Parent or Guardian Certification
        </td>
        <td>
            As parent or legal guardian of <b>{{ $registrant->student->person->fullname }}</b>,
            I give my permission for {{ $registrant->student->person->pronoun->possessive }}
            to be an applicant for this organization.  I understand that neither
            {{ $school->name }} nor {{ $eventversion->event->organization->name }} assumes responsibility
            for illness or accident.  I further attest the statement signed by
            <b>{{ $registrant->student->person->fullname }}</b> and will assist
            {{ $registrant->student->person->pronoun->possessive }} in fulfilling
            the obligations incurred.
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black;">Signature</td>
        <td style="border-bottom: 1px solid black; @if($eapplication->signatureguardian) font-style: italic; font-size: 1rem; font-weight: bold; @else color: darkgrey; @endif">
            @if($eapplication->signatureguardian){{ $registrant->student->guardians->first()->person->fullname }}
            @else Unsigned
            @endif
        </td>
    </tr>
</table>

<div style="text-align: center;">Page 2/2</div>


</body>
</html>
