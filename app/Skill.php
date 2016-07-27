<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'created_at', 'updated_at'];

    protected function jobs ()
    {
        return $this->belongsToMany(Job::class)->withTimestamps();
    }
}
