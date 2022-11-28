<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model
{
    use HasFactory;

    protected $fillable = ['descr'];

    const REGISTRATION = 1;
    const PARTICIPATION = 2;
    const HOUSING = 3;
    const OTHER = 4;
}
