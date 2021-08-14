<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileupload extends Model
{
    use HasFactory;

    protected $fillable = ['approved', 'approved_by', 'filecontenttype_id', 'folder_id',
        'registrant_id', 'server_id', 'uploaded_by'];
}
