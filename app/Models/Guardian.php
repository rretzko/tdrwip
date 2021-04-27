<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];
    protected $primaryKey = 'user_id';

    public function getEmailAlternateAttribute()
    {
        return $this->getEmail('email_guardian_alternate');
    }

    public function getEmailPrimaryAttribute()
    {
        return $this->getEmail('email_guardian_primary');
    }

    public function getPhoneHomeAttribute()
    {
        return $this->getPhone('phone_guardian_home');
    }

    public function getPhoneMobileAttribute()
    {
        return $this->getPhone('phone_guardian_mobile');
    }

    public function getPhoneWorkAttribute()
    {
        return $this->getPhone('phone_guardian_work');
    }

    public function guardiantype()
    {
        return Guardiantype::find($this->pivot->guardiantype_id);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'guardian_student', 'guardian_user_id', 'student_user_id')
            ->withPivot('guardiantype_id');
    }

    public function person()
    {
        return $this->hasOne(Person::class, 'user_id', 'user_id');
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/

    private function getEmail($emailtype_descr)
    {
        return Nonsubscriberemail::find(
            DB::table('nonsubscriberemails')
                ->select('id')
                ->where('user_id', $this->user_id)
                ->where('emailtype_id', Emailtype::where('descr', $emailtype_descr)->first()->id)
                ->value('id')
            ?? 0
        )
            ?? new Email;
    }

    private function getPhone($phonetype_descr)
    {
        return Phone::find(
                DB::table('phones')
                    ->select('id')
                    ->where('user_id', $this->user_id)
                    ->where('phonetype_id', Phonetype::where('descr', $phonetype_descr)->first()->id)
                    ->value('id')
                ?? 0
            )
            ?? new Phone;
    }
}
