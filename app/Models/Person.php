<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use Encryptable,HasFactory;

    protected $encryptable = [ //encryptable fields
        'first',
        'middle',
        'last'
    ];

    protected $fillable = [
        'first', 'middle', 'last', 'honorific_id', 'pronoun_id','user_id',
    ];

    protected $primaryKey = 'user_id';

    public function getFullNameAttribute()
    {
        $str = $this->first;
        $str .= (strlen($this->middle)) ? ' '.$this->middle : '';
        $str .= ' '.$this->last;

        return $str;
    }

    public function getFullNameAlphaAttribute()
    {
        $str = $this->last;
        $str .= ', '.$this->first;
        $str .= (strlen($this->middle)) ? ' '.$this->middle : '';

        return $str;
    }

    public function getHonorificDescrAttribute()
    {
        return Honorific::find($this->honorific_id)->abbr;
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class,'user_id', 'user_id');
    }

    public function honorific()
    {
        return $this->belongsTo(Honorific::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'user_id');
    }

    public function pronoun()
    {
        return $this->belongsTo(Pronoun::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class,'user_id', 'user_id');
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
