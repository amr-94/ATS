<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use App\Resources\JobResource;
use App\Traits\ApiResponse;

class JobRepository implements JobRepositoryInterface
{
    use ApiResponse;

    protected $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function index()
    {
        try {
            $jobs = $this->model->with('recruiter:id,name')->get();
            return $this->successResponse(JobResource::collection($jobs), 'Jobs retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $job = $this->model->with('recruiter:id,name')->findOrFail($id);
            return $this->successResponse(new JobResource($job), 'Job retrieved successfully');
        } catch (\Exception $e) {
            return $this->notFoundResponse('Job not found');
        }
    }

    public function create(array $data)
    {
        try {
            $job = $this->model->create($data);
            return $this->successResponse(new JobResource($job), 'Job created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $job = $this->model->findOrFail($id);
            $job->update($data);
            return $this->successResponse(new JobResource($job), 'Job updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            $this->model->findOrFail($id)->delete();
            return $this->successResponse(null, 'Job deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
