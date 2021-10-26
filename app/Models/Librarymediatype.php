<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarymediatype extends Model
{
    use HasFactory;
    
    const SHEET_MUSIC = 1;
    const COMPILATION = 2;
    const CD = 3;
    const VINYL = 4;
    const DVD = 5;
    const CASSETTE = 6;
}
