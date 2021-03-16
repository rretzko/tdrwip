<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studiodetail extends Model
{
    use HasFactory;

    protected $fillable = ['studio_id','opened','closed'];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
