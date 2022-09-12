<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Library Questionnaire
 */
class Qlibrary extends Model
{
    use HasFactory;

    protected $primaryKey='user_id';

    protected $fillable=['accompaniment','arranger','arrangement','comments','composer','concert','ensemble','language',
        'must_haves','nice_haves','publisher','subtitle','tempo','title','user_id','year'];
}
