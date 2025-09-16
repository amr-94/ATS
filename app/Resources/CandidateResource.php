<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'resume' => $this->resume_path  ? asset('storage/' . $this->resume_path) : null,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}