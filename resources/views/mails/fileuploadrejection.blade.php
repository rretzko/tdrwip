==================================================================================
|   PLEASE DISREGARD THIS EMAIL.  WE ARE TESTING THE ALL-STATE SYSTEM RIGHT NOW! |
==================================================================================
Mail should be sent to: {{ $sendto }}
cc should be sent to: {{ auth()->user()->person->subscriberemailwork }}
Hi, {{ $registrant->student->person->first }} -

{{ auth()->user()->person->fullName }} has requested that you re-submit your {{ strtoupper($filecontenttype->descr) }} audition
file for  {{ $eventversion->name }}.

You may resubmit this file by logging into <a href="https://studentfolder.info">StudentFolder.info</a>
and clicking the 'Event' link.

Thanks!

Rick Retzko
Founder: TheAuditionSuite.com
