<?php

namespace App\Http\Controllers\Web\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Interfaces\JobRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index()
    {
        $jobs = Auth::guard('recruiter-web')->user()
            ->jobs()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('recruiter.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('recruiter.jobs.create');
    }

    public function store(StoreJobRequest $request)
    {


        $data = $request->validated();
        $data['recruiter_id'] = Auth::guard('recruiter-web')->id();

        $this->jobRepository->create($data);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job created successfully');
    }

    public function edit($id)
    {

        $job = $this->jobRepository->show($id);

        if ($job->recruiter_id !== Auth::guard('recruiter-web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('recruiter.jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, $id)
    {
        $data =  $request->validated();

        $job = $this->jobRepository->show($id);

        if ($job->recruiter_id !== Auth::guard('recruiter-web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->jobRepository->update($id, $data);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job updated successfully');
    }

    public function destroy($id)
    {
        $job = $this->jobRepository->show($id);

        if ($job->recruiter_id !== Auth::guard('recruiter-web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->jobRepository->delete($id);

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job deleted successfully');
    }
}
