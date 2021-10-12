<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datetype extends Model
{
    use HasFactory;

    const SCORE_OPEN=11;
    const SCORE_CLOSE=12;

    protected $fillable = ['id','descr'];
}
