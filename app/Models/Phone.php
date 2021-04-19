<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use Encryptable,HasFactory;

    protected $encryptable = ['phone'];

    protected $fillable = ['phone','phonetype_id', 'user_id'];

    public function person()
    {
        return $this->hasOne(User::class);
    }
}
