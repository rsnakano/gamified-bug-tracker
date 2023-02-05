<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'leader_id',
        'completed'
    ];


    public function bugs() {
        return $this->hasMany(Bug::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
