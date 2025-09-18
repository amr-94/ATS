<?php

namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Interfaces\JobRepositoryInterface;
use App\Resources\JobResource;
use App\Traits\ApiResponse;

class JobController extends Controller
{
    use ApiResponse;

    protected $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index()
    {
        try {
            $jobs = $this->jobRepository->index();
            return $this->successResponse(JobResource::collection($jobs), 'Jobs retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $job = $this->jobRepository->show($id);
            return $this->successResponse(new JobResource($job), 'Job retrieved successfully');
        } catch (\Exception $e) {
            return $this->notFoundResponse('Job not found');
        }
    }

    public function store(StoreJobRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['recruiter_id'] = auth()->id();
            $job = $this->jobRepository->create($validated);

            return $this->successResponse(new JobResource($job), 'Job created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateJobRequest $request, $id)
    {
        try {
            $job = $this->jobRepository->update($id, $request->validated());
            return $this->successResponse(new JobResource($job), 'Job updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobRepository->delete($id);
            return $this->successResponse(null, 'Job deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
