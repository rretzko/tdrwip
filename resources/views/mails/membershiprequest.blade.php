Hi, {{ $sendto->first }} -

{{ $event->requester->fullName }} has requested admittance to {{ $event->organization->name }}.
{!! $datatable !!}
Name: {{ $event->requester->fullName }}
School(s): @foreach($event->requester->user->schools AS $school)
            {{ $school->name }},
    @endforeach

Please click here to grant {{ $event->requester->first }} admittance to {{ $event->organization->name }} events.

Thanks!

Rick Retzko
Founder: TheAuditionSuite.com

