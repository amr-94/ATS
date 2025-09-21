<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    protected $fillable = [
        'application_id',
        'meeting_id',
        'topic',
        'start_time',
        'duration',
        'join_url',
        'password'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
