<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['user_id','title','description','status', 'created_at', 'updated_at'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function skills ()
    {
        return $this->belongsToMany(Skill::class)->withTimestamps();
    }



}
