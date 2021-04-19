<?php

namespace App\Traits;

trait FormatPhoneTrait
{
    /**
     * Return the current senior year
     * if the current month is Jan-June, return the current year, else
     * return the next year
     *
     * @return int
     */
    public function formatPhone($str) : string
    {
        //break string into integer value
        $ints = $this->stripNonnumericValues($str);

        //format into }(###) ###-#### [x####]" string
        if(strlen($ints) < 10){ return 'Err: Please include area code!';}

        if(strlen($ints) === 10){

            //(###) ###-####
            return '('.substr($ints,0,3).') '.substr($ints,3,3).'-'.substr($ints,6);
        }

        //(###) ###-#### x###...
        return '('.substr($ints,0,3).') '.substr($ints,3,3).'-'.substr($ints,6, 4).' x'.substr($ints,10);
    }

    private function stripNonnumericValues($str)
    {
        //early exit
        if(is_int($str)){ return $str;}

        $chars = str_split($str);

        $ints = '';

        foreach($chars AS $char){

            if(is_numeric($char)){

                $ints .= $char;
            }
        }

        return $ints;
    }
}
