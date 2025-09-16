<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'status' => $this->status,
            'recruiter'  => $this->whenLoaded('recruiter', function () {
                return [
                    'id'   => $this->recruiter->id,
                    'name' => $this->recruiter->name,
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
