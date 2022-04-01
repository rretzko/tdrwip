<?php

namespace App\Traits;

use Carbon\Carbon;

trait ExceptionsTrait
{
    /**
     * Return the current senior year
     * if the current month is Jan-June, return the current year, else
     * return the next year
     *
     * @return int
     */
    public function exceptions() : int
    {
        $exceptions =
            [
                71 => [ //2022-23 NJ All-State;
                    'users' => [180,9136,10125], //John Wilson, Matt Wolf, Blaze Dalio
                    'start' => '2022-04-01 17:09:01',
                    'end' => '2022-04-01 17:27:59',
                    ],
            ];

        $eventversionid = \App\Models\Userconfig::getValue('eventversion', auth()->id());
        $users = $exceptions[$eventversionid]['users'];
        $start = $exceptions[$eventversionid]['start'];
        $end = $exceptions[$eventversionid]['end'];

        return (in_array(auth()->id(), $users) &&
            (Carbon::now() > $start) &&
            (Carbon::now() < $end)
        );
    }
}
