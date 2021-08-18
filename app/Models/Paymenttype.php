<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymenttype extends Model
{
    use HasFactory;

    protected $fillable = ['descr'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
