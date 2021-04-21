<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailtype extends Model
{
    use HasFactory;

    public function nonsubscriberemails()
    {
        return $this->hasMany(Nonsubscriberemail::class);
    }
}
