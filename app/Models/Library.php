<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'user_id'];
    protected $with=['school'];

    public function compositions()
    {
        return $this->belongsToMany(Composition::class)
            ->with('publisher');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
