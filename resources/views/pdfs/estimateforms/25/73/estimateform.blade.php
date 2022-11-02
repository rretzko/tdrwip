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
<div style="margin-bottom: 1rem;">The pages below should be sent to the <b>Registration Manager</b>  </div>

{{-- PAGE HEADER --}}
<table>
    <tr>
        <td style="width: 10%;">
            <!-- <img src="https://thedirectorsroom.com/assets/images/njmea_logo_state.jpg" alt="NJMEA Logo"/> -->
        </td>
        <td style="width: 72%;text-align: right;">
            <div style="font-weight: bold; text-align: right; ">{{ strtoupper($eventversion->name) }}</div>
            <div style="text-align: right"><span style="border-top: 1px solid darkgrey;">2022-2023 TEACHER ESTIMATE FORM</span></div>
            <div style="text-align: right; font-size: 1rem;">
                {{ $me->person->fullName }}
            </div>
            <div>
                {{ $school->shortName }}
            </div>
        </td>
    </tr>
</table>
<!-- {{--
<table>
    <tr>
        <th style="text-align: center; border-bottom: 1px solid darkgrey;">{{ $eventversion->eventversionconfigs->max_count }} STUDENTS MAXIMUM</th>
    </tr>
</table>
--}} -->

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
    <!-- {{--
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
    --}} -->
    @forelse($registrants AS $registrant)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="">{{ $registrant->student->person->fullNameAlpha }}</td>
            <td class="text-center">{{ $registrant->instrumentations->first()->descr }}</td>
            <td class="text-center">{{ $registrant->student->grade }}</td>
            <td class="text-center">${{ $eventversion->eventversionconfigs->registrationfee * ($loop->iteration) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center">No registrants found</td>
        </tr>
    @endforelse
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
        <th>Total Fees</th>
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

</body>
</html>
