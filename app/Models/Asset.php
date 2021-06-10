<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['descr'];

    public function ensembles()
    {
        return $this->belongsToMany(Ensemble::class)
            ->withTimestamps();
    }
}
