<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ensemble extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'school_id', 'name', 'abbr','descr'];

    public function path()
    {
        return "/ensemble/{$this->id}";
    }
}
