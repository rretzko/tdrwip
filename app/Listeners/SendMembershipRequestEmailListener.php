<?php

namespace App\Listeners;

use App\Events\MembershipRequestEvent;
use App\Mail\MembershipRequestMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMembershipRequestEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MembershipRequestEvent  $event
     * @return void
     */
    public function handle(MembershipRequestEvent $event)
    {
        $datatable = $this->datatable($event);
        foreach($event->organization->membershipmanagers() AS $sendto){

            foreach($sendto->subscriberEmails AS $email){

                Mail::to($email->email)->send(new MembershipRequestMail($event, $sendto, $datatable));
            }

        }

    }

    private function datatable($event)
    {
        $str = '<table>';

        $str .= '<tbody>';

        $str .=
            '<tr>'
            . '<td>Name</td>'
            . '<th>' . $event->requester->fullName . '</th>'
            . '</tr>';

        $str .=
            '<tr>'
            . '<td>School(s)</td>'
            . '<th>';
        foreach ($event->requester->user->schools as $school){
            $str .= $school->name . '<br />';
        }
        $str .='</th>'
            .'</tr>';

        $str .= '</tbody>';

        $str .= '</table>';

        return $str;
    }
}
