<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = ['phone','phonetype_id', 'user_id'];

    public function person()
    {
        return $this->hasOne(User::class);
    }
}
