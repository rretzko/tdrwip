<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'first', 'middle', 'last', 'honorific_id', 'pronoun_id','user_id',
    ];

    protected $primaryKey = 'user_id';

    public function honorific()
    {
        return $this->hasOne(Honorific::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'user_id');
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class);
    }

    public function subscriberemails()
    {
        return $this->hasMany(Subscriberemail::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class,'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
