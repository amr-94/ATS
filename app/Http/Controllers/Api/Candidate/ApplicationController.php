<?php

namespace App\Http\Controllers\Api\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Interfaces\ApplicationRepositoryInterface;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function index(Request $request)
    {
        return $this->applicationRepository->index($request);
    }

    public function apply(StoreApplicationRequest $request, Job $job)
    {
        $validated = $request->validated();

        $data = [
            'candidate_id' => auth('candidate')->id(),
            'job_id' => $job->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'current_stage' => 'applied'
        ];

        return $this->applicationRepository->create($data);
    }

    public function myApplications()
    {
        return $this->applicationRepository->getByCandidateId(auth('candidate')->id());
    }
}
