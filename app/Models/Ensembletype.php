<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ensembletype extends Model
{
    use \Sushi\Sushi;

    protected $rows = [
        ['id' => 1, 'descr' => 'SSAATTBB',],
        ['id' => 2, 'descr' => 'SATB',],
        ['id' => 3, 'descr' => 'SSAA'],
        ['id' => 4, 'descr' => 'TTBB'],
    ];
}
