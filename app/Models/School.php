<?php

namespace App\Models;

use App\Models\Registrant;
use App\Models\Registranttype;
use App\Traits\MailingAddressTrait;
use App\Traits\SenioryearTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    use HasFactory,MailingAddressTrait,SenioryearTrait, SoftDeletes;

    protected $fillable = ['name', 'address01', 'address02', 'city', 'county_id', 'geostate_id', 'postalcode'];

    public function acceptedRegistrants(Eventversion $eventversion)
    {
        $unsuccessfuls = ['na','n/a','inc'];

        $ids =  DB::table('registrants')
            ->join('scoresummaries','registrants.id','=','scoresummaries.registrant_id')
            ->where('registrants.eventversion_id', $eventversion->id)
            ->where('registrants.school_id', $this->id)
            ->whereNotIn('scoresummaries.result', $unsuccessfuls)
            ->pluck('registrants.id');

        return Registrant::find($ids)->sortBy('student.person.last');
    }

    public function ensembles()
    {
        return $this->hasMany(Ensemble::class)
            ->with('ensembletype', 'ensembletype.instrumentations');
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function getCurrentStudentsAttribute()
    {
        $students = collect();

        $users =  $this->students()->filter(function($user){
            return $user->person->student->classof >= $this->senioryear();
        });

        foreach($users AS $user){
            $students->push(Student::find($user->id));
        }

        return $students->sortBy('person.last');

    }

    public function getCurrentUserGradesAttribute()
    {
        $grades = DB::table('gradetype_school_user')
            ->where('school_id', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->pluck('gradetype_id')
            ->toArray();

        return $grades;
    }

    public function getCurrentGradesAllUsersAttribute()
    {
        $grades = DB::table('gradetype_school_user')
            ->where('school_id', '=', $this->id)
            ->pluck('gradetype_id')
            ->toArray();

        return $grades;
    }

    public function getGeostateAbbrAttribute()
    {
        return ($this->geostate_id) ? Geostate::where('id', $this->geostate_id)->first()->abbr : 'ZZ';
    }

    public function getMailingAddressAttribute()
    {
        return $this->mailingAddress($this);
    }

    /**
     * @since 2020.05.28
     *
     * abbreviate common terms
     *
     * @return string
     */
    public function getShortNameAttribute() : string
    {
        $abbrs = [
            'High School' => 'HS',
            'Regional High School' => 'RHS',
            'International' => 'Int\'l',
            'University' => 'U',
        ];

        //early exit
        if(is_null($this->name) || (! strlen($this->name))){ return 'No school name found';}

        $haystack = $this->name; //avoid repeated downstream calls

        $str = $haystack;   //initialize $str value

        foreach($abbrs AS $descr => $abbr){

            if(strstr($haystack, $descr)){

                $str = str_replace($descr, $abbr, $haystack);
            }
        }

        return $str;
    }

    public function paymentsParticipationXPaypalBalanceDue(): float
    {
        $eventversion = Eventversion::find(UserConfig::getValue('eventversion', auth()->id()));
        $participation_fee = $eventversion->eventversionconfigs->participation_fee_amount;
        $accepted_count = $this->acceptedRegistrants($eventversion)->count();
        $paypal_payments = $this->paymentsParticipationPaypal();
        $total_due = ($accepted_count * $participation_fee);

        return ($total_due - $paypal_payments);
    }

    public function paymentsParticipationXPaypalBalanceDueFormatted() : string
    {
        return '$'.number_format($this->paymentsParticipationXPaypalBalanceDue(), 2);
    }

    public function paymentsParticipationBalanceDue(): float
    {
        $eventversion = Eventversion::find(UserConfig::getValue('eventversion', auth()->id()));
        $accepteds_count = $this->acceptedRegistrants($eventversion)->count();
        $participation_fee = $eventversion->eventversionconfigs->participation_fee_amount;
        $total_due = ($accepteds_count * $participation_fee);
        $paypal_paid = Payment::where('school_id', $this->id)
            ->where('eventversion_id', $eventversion->id)
            ->where('paymentcategory_id', PaymentCategory::PARTICIPATION)
            ->where('paymenttype_id', Paymenttype::PAYPAL)
            ->sum('amount');

        return ($total_due - $paypal_paid);
    }

    public function paymentsParticipationBalanceDueFormatted(): string
    {
        return '$'.number_format($this->paymentsParticipationBalanceDue(), 2);
    }

    public function paymentsParticipationXPaypal(): float
    {
        return Payment::where('school_id', $this->id)
            ->where('paymentcategory_id', PaymentCategory::PARTICIPATION)
            ->where('paymenttype_id', '!=',Paymenttype::PAYPAL)
            ->whereNotNull('registrant_id')
            ->sum('amount') ?: 0;
    }

    public function paymentsParticipationXPaypalFormatted() : string
    {
        return '$'.number_format($this->paymentsParticipationXPaypal(), 2);
    }

    public function paymentsParticipationPaypal(): float
    {
        return Payment::where('school_id', $this->id)
            ->where('paymentcategory_id', PaymentCategory::PARTICIPATION)
            ->where('paymenttype_id', Paymenttype::PAYPAL)
            ->whereNotNull('registrant_id')
            ->sum('amount') ?: 0;
    }

    public function paymentsParticipationPaypalFormatted() : string
    {
        return '$'.number_format($this->paymentsParticipationPaypal(), 2);
    }

    public function paymentsParticipationPaypalSchool(): float
    {
        return Payment::where('school_id', $this->id)
            ->where('paymentcategory_id', PaymentCategory::PARTICIPATION)
            ->where('eventversion_id', UserConfig::getValue('eventversion', auth()->id()))
            ->where('registrant_id', null)
            ->sum('amount');
    }

    public function paymentsParticipationPaypalSchoolFormatted(): string
    {
        return '$'.number_format($this->paymentsParticipationPaypalSchool(), 2);
    }

    public function students()
    {
        return $this->users->filter(function($user){
           return $user->isStudent();
        });
    }

    /**
     * @todo See if this is used anywhere; it shouldn't work...
     * @return BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'user_id', 'user_id');
    }

    /**
     * Designed for use in Http/Livewire/Siteadministration/Siteadministrator
     */
    public function teachersForTransfer()
    {
        $teachers = collect();

        foreach($this->users AS $user){

            if($user->isTeacher()){

                $teachers->push(Teacher::find($user->id));
            }
        }

        return $teachers->sortBy('person.last');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
