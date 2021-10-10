<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecontenttype extends Model
{
    use HasFactory;

    protected $fillable = ['descr'];

    public function scoringcomponents()
    {
        return $this->hasMany(\App\Models\Scoringcomponent::class)
            ->orderBy('order_by');
    }
}
