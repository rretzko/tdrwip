<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'honorific_id', 'pronoun_id'
    ];

    protected $primaryKey = 'user_id';

    public function honorific()
    {
        return $this->hasOne(Honorific::class);
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
