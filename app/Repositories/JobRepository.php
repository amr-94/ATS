<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface
{
    protected $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function index()
    {
        return $this->model->with('recruiter:id,name')->get();
    }

    public function show($id)
    {
        return $this->model->with('recruiter:id,name')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $job = $this->model->findOrFail($id);
        $job->update($data);
        return $job;
    }

    public function delete($id)
    {
        $job = $this->model->findOrFail($id);
        return $job->delete();
    }
}
