<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationStageTransition extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'application_id',
        'from_stage',
        'to_stage',
        'changed_by',
        'notes'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
