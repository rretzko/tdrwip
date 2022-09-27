<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'eventversion_id', 'paymenttype_id', 'registrant_id', 'school_id', 'vendor_id',
        'updated_by','user_id',];

    public function paymenttype()
    {
        return $this->belongsTo(Paymenttype::class);
    }

    public function recordIPNPayment(array $dto)
    {
        Payment::create(
            [
                'user_id' => $dto['user_id'],
                'registrant_id' => $dto['registrant_id'],
                'eventversion_id' => $dto['eventversion_id'],
                'paymenttype_id' => $dto['paymenttype_id'],
                'school_id' => $dto['school_id'],
                'vendor_id' => $dto['vendor_id'],
                'amount' => $dto['amount'],
                'updated_by' => 368,
            ],
        );
    }

}
