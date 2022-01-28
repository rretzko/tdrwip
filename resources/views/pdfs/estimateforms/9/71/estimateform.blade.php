<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            margin-bottom: 1rem;
            width: 96%;
        }
        .page_break{page-break-before: always;}
    </style>
    <title></title>
</head>
<body style="border: 1px solid white; padding: 1rem; ">

{{-- SEND TO INSTRUCTIONS --}}
{{-- SEND TO --}}
<table>
    <tr>
        <td>The pages below should be sent to: </td>
    </tr>
    <tr>
        <td>
            <b>{{ $sendto['name'] }}</b>
        </td>
    </tr>
    <tr>
        <td>{{ $sendto['address01'] }}</td>
    </tr>
    <tr>
        <td>{{ $sendto['address02'] }}</td>
    </tr>
    @if(strlen($sendto['address03']))
        <tr>
            <td>{{ $sendto['address03'] }}</td>
        </tr>
    @endif
</table>

{{-- PAGE BREAK --}}
<div class="page_break"></div>

{{-- PAGE HEADER --}}
<table>
    <tr>
        <td style="width: 10%;">
            <img src="https://thedirectorsroom.com/assets/images/njmea_logo_state.jpg" alt="NJMEA Logo"/>
        </td>
        <td style="width: 72%;text-align: right;">
            <div style="font-weight: bold; text-align: right; ">{{ strtoupper($eventversion->name) }}</div>
            <div style="text-align: right"><span style="border-top: 1px solid darkgrey;">2021-2022 TEACHER ESTIMATE FORM</span></div>
            <div style="text-align: right; font-size: 1rem;">
                {{ $me->person->fullName }}
            </div>
            <div>
                {{ $school->shortName }}
            </div>
        </td>
    </tr>
</table>

<table>
    <tr>
        <th style="text-align: center; border-bottom: 1px solid darkgrey;">{{ $eventversion->eventversionconfigs->max_count }} STUDENTS MAXIMUM</th>
    </tr>
</table>

<style>#roster{font-size: .9rem;} #roster td,#roster th{border: 1px solid black; text-align: center;}</style>
<table style="border-collapse: collapse;" id="roster">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Voice Part</th>
        <th>Grade</th>
        <th>Fee</th>
    </tr>
    </thead>
    <tbody>
    @for($i=0;$i<$eventversion->eventversionconfigs->max_count;$i++)
        @if(isset($registrants[$i]))
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td style="text-align: left;padding-left: .25rem;">{{ $registrants[$i]->student->person->fullNameAlpha }}</td>
                <td>{{ $registrants[$i]->instrumentations->first()->descr }}</td>
                <td>{{ $registrants[$i]->student->grade }}</td>
                <td>${{ $eventversion->eventversionconfigs->registrationfee * ($i + 1) }}</td>
            </tr>
        @else
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>${{ $eventversion->eventversionconfigs->registrationfee * ($i + 1) }}</td>
            </tr>
        @endif

    @endfor
    </tbody>
</table>

{{-- SUMMARY TABLE --}}
<style>
    #summary td,#summary th{border: 1px solid black; text-align: center;}
</style>
{{-- SUMMARY TABLE --}}
<table id="summary">
    <thead>
    <tr>
        <th style="border-top: 0; border-left: 0; "></th>
        @foreach($eventversion->instrumentations() AS $instrumentation)
            <th >{{ strtoupper($instrumentation->abbr) }}</th>
        @endforeach
        <th>Total Enclosed</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Voice Part Totals</td>
        @foreach($eventversion->instrumentations() AS $instrumentation)
            <th style="{{ (! $registrantsbyinstrumentation[$instrumentation->id]) ? 'color:lightgrey;' : '' }}">
                {{ $registrantsbyinstrumentation[$instrumentation->id] }}
            </th>
        @endforeach
        <td style="text-align: center">${{ array_sum($registrantsbyinstrumentation) * $eventversion->eventversionconfigs->registrationfee }}</td>
    </tr>
    </tbody>
</table>

{{-- PAGE BREAK --}}
<div class="page_break"></div>

{{-- MEMBERSHIP CARD --}}
<table>
    <tr>
        <td style="width: 10%; text-align: center;">
            <img src="https://thedirectorsroom.com/assets/images/NAfME_cropped.jpg" width="600px" alt="NAfME Logo"/>
        </td>
    </tr>
</table>


<table id="membership" style="margin-top: 1rem;">
    <tr>
        <td colspan="2" style="font-size: 1.5rem; font-weight: bold; text-align: center">
            Please attach a copy of your current NAfME card here.<br />
        Membership must be current through December 2022.
        </td>
    </tr>

    <tr><td colspan="2" style="color: white; font-size: 2rem;">Spacer</td></tr>

    @if($membership)
        <tr style="height: 20px;">
            <td colspan="2" style="text-align: center;font-weight: bold;">
                {{ auth()->user()->person->fullnameAlpha }}
            </td>
        </tr>
        <tr style="height: 20px;">
            <td style="text-align: right; padding-right: 0.5rem; width: 50%;">
                Status
            </td>
            <td style="text-align: left; font-weight: bold;">
                {{ $membership->membershiptype->descr }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 0.5rem; width: 50%;">
                Expiration
            </td>
            <td style="text-align: left; font-weight: bold;">
                {{ $membership->expirationMdy() }}
            </td>
        </tr>
        @if(strlen($membership->membership_card_path))

            <tr><td colspan="2" style="color: white; font-size: 2rem;">Spacer</td></tr>

            <tr>
                <td colspan="2" style="text-align: center;">
                    <img src="../public{{ $membership->membership_card_path }}"
                         alt="membership card image" width="600px"
                    />
                </td>
            </tr>

        @endif
    @endif

</table>

<table>
    <tr>
        <td style="font-size:2rem; color: transparent;">DELIBERATELY BLANK</td>
    </tr>
</table>

<table>
    <tr>
        <td style="font-size: 1.5rem; font-weight: bold; text-align: center">
            Please contact NAfME at 800.828.0229 or <br />
            www.nafme.org for validation/renewal.
        </td>
    </tr>
</table>

<div class="page_break"></div>

{{-- COVID ADVISORY --}}

{{-- COVID-19 --}}
<table class="endorsements" style="margin-top: 1rem; border: 1px solid darkgray;">
    <tr style="background-color: rgba(0,0,0,.1);">
        <th style="text-align: center; padding: .5rem;">
            COVID-19 ADVISORY
        </th>
    </tr>
    <tr>
        <td style="text-align: justify; padding: .5rem;">
            By registering for/attending this event, I acknowledge that I fully understand the nature and extent of the
            risks presented by COVID-19 due to my in-person attendance at this event, including the risk that COVID-19 may
            lead to severe illness or death. I also understand and acknowledge that there are risks of exposure to COVID-19,
            whether resulting from travel through high-risk areas, the failure of other individuals to follow proper COVID-19
            protocols, such as maintaining proper social distancing and proper hygiene measures, and other such risks.
            While I understand that CJMEA has taken reasonable steps to address the risks presented by COVID-19, I recognize
            that the COVID-19 protocols being utilized at the event may be insufficient to prevent my contracting COVID-19
            and suffering any related injuries, and that I expressly nevertheless assume all of these risks.
        </td>
    </tr>
    <tr>
        <td style="text-align: justify; padding: .5rem;">
            With full knowledge of the risks involved, therefore, I hereby release, waive, and discharge CJMEA, its officers,
            directors, employees, contractors, and agents, from any and all liability, loss, damage, claims, demands, actions,
            and causes of action whatsoever, including reasonable attorneys' fees, directly or indirectly arising out of
            or related to any loss, damage, injury, or death, that may be sustained by me while participating in this event
            or while in, on, or around the event premises that may lead to exposure or harm due to COVID-19.
        </td>
    </tr>
</table>


</body>
</html>
