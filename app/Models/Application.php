<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'current_stage'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function stageTransitions()
    {
        return $this->hasMany(ApplicationStageTransition::class);
    }
    public function zoomMeeting()
    {
        return $this->hasOne(\App\Models\ZoomMeeting::class, 'application_id');
    }
}
