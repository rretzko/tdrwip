<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrumentation extends Model
{
    use HasFactory;

    public function instrumentationbranch()
    {
        return $this->belongsTo(Instrumentationbranch::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
