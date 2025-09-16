<?php


namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Interfaces\JobRepositoryInterface;

class JobController extends Controller
{
    protected $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index()
    {
        return $this->jobRepository->index();
    }

    public function show($id)
    {
        return $this->jobRepository->show($id);
    }

    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();
        $validated['recruiter_id'] = auth()->id();
        return $this->jobRepository->create($validated);
    }

    public function update(UpdateJobRequest $request, $id)
    {
        return $this->jobRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->jobRepository->delete($id);
    }
}
