<?php

namespace App\Traits;

use App\Models\Searchable;

trait UsernameTrait
{
    /**
     * @since 2021.03.03
     *
     * Trait for creating/updating username

     * @return string
     */
    public function username($str) : string
    {
        $parts = explode(' ',$str);


        $searchable = new Searchable();

        $searchable->add($user_id, $descr, $raw);
    }
}
