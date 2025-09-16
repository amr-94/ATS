<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'recruiter_id',
        'title',
        'description',
        'location',
        'status'
    ];
    protected $table = 'recuiterjobs';


    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
