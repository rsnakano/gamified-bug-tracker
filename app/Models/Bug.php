<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    use HasFactory;

    protected $fillable = [
        'bug_name',
        'project_id',
        'completed',
        'completed_by',
        'completed_date',
    ];
}
