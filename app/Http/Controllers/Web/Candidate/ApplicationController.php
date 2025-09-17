<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function availableJobs()
    {
        $jobs = Job::where('status', 'open')
            ->with('recruiter')
            ->latest()
            ->paginate(10);

        return view('candidate.jobs.index', compact('jobs'));
    }

    public function myApplications()
    {
        $applications = Auth::guard('candidate-web')->user()
            ->applications()
            ->with(['job', 'job.recruiter'])
            ->latest()
            ->paginate(10);

        return view('candidate.applications.index', compact('applications'));
    }


    public function apply(Request $request,  $id)
    {
        $job = Job::findOrFail($id);
        $request->validate([
            'cover_letter' => 'required|string|min:0'
        ]);

        $candidate = Auth::guard('candidate-web')->user();

        $application = Application::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'cover_letter' => $request->cover_letter,
            'current_stage' => 'applied'
        ]);

        return redirect()
            ->route('candidate.applications.index')
            ->with('success', 'Application submitted successfully');
    }
}
