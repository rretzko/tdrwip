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
    </style>
    <title></title>
</head>
<body style="border: 1px solid white; padding: 1rem; ">

{{-- PAGE HEADER --}}
<table>
    <tr>
        <td style="width: 10%;">
            <img src="assets\images\njmea_logo_state.jpg" alt="NJMEA Logo"/>
        </td>
        <td style="width: 72%;text-align: right;">
            <div style="font-weight: bold; text-align: right; ">{{ strtoupper($eventversion->name) }}</div>
            <div style="text-align: right"><span style="border-top: 1px solid darkgrey;">2021-2022 TEACHER ESTIMATE FORM</span></div>
            <div style="text-align: right; font-size: 1rem;">
                {{ $me->person->fullName }}
            </div>
            <div>
                {{ $me->schools->first()->name }}
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

{{-- SPACER --}}
<table>
    <tr><td></td></tr>
    <tr><td></td></tr>
</table>

<table>
    <tr>
        <td style="width: 25%;">NAfME logo</td>
        <td style="font-size: 2rem; font-weight: bold; text-align: center;">National Association<br /><i>for</i> Music Education</td>
    </tr>
</table>

<table>
    <tr>
        <td style="font-size: 1.5rem; font-weight: bold; text-align: center">
            Please attach a copy of your current NAfME card here.<br />
        Membership must be current through December 2021.
        </td>
    </tr>
    <tr>
        <td style="font-size: 1.25rem; font-weight: bold; text-align: center">
            Note: If you uploaded a copy of your membership card into
            TheDirectorsRoom.com, it will be printed below.
        </td>
    </tr>
</table>

<table>
    <tr>
        <td style="font-size:12rem; color: transparent;">DELIBERATELY BLANK</td>
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

</body>
</html>