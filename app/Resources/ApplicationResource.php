<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'job' => new JobResource($this->job),
            'candidate' => new CandidateResource($this->candidate),
            'cover_letter' => $this->cover_letter,
            'current_stage' => $this->current_stage,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
