<?php

namespace App\Traits;

use App\Models\Emailtype;
use App\Models\Nonsubscriberemail;
use App\Models\Phone;
use App\Models\Phonetype;

trait StoreCommunicationObject
{
    private function saveEmails()
    {
        $emails = [
            'primary' => ['obj' => null, 'emailtype_descr' => 'email_guardian_primary', 'current' => $this->emailprimary,],
            'personal' => ['obj' => null, 'emailtype_descr' => 'email_student_personal', 'current' => $this->emailpersonal,],
            'school' => ['obj' => null, 'emailtype_descr' => 'email_student_school', 'current' => $this->emailschool,],
        ];

        foreach ($emails as $email) {
            $email['obj'] = Nonsubscriberemail::firstOrCreate(
                [
                    'user_id' => $this->student->user_id,
                    'emailtype_id' => Emailtype::where('descr', $email['emailtype_descr'])->first()->id,
                ],
                [
                    'email' => $email['current'],
                ]
            );

            //update object if user's input differs from current record
            if ($email['current'] !== $email['obj']->email) {
                $email['obj']->email = $email['current'];
                $email['obj']->save();
            }
        }
    }

    private function savePhones()
    {
        $phones = [
            'home' => ['obj' => null, 'phonetype_descr' => 'phone_student_home', 'current' => $this->phonehome,],
            'mobile' => ['obj' => null, 'phonetype_descr' => 'phone_student_mobile', 'current' => $this->phonemobile,],
        ];

        foreach ($phones as $phone) {
            $phone['obj'] = Phone::firstOrCreate(
                [
                    'user_id' => $this->student->user_id,
                    'phonetype_id' => Phonetype::where('descr', $phone['phonetype_descr'])->first()->id,
                ],
                [
                    'phone' => $phone['current'],
                ]
            );

            //update object if user's input differs from current record
            if ($phone['current'] !== $phone['obj']->phone) {
                $phone['obj']->phone = $phone['current'];
                $phone['obj']->save();
            }
        }

    }


    private function stripPhone($str)
    {
        $chars = str_split($str);

        $ints = array_filter($chars, function($char){
            return is_numeric($char);
        });

        return implode($ints);
    }
}
