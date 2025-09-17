<?php

namespace App\Http\Controllers\Web\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'status' => 'required|in:open,closed',
        ]);

        Auth::guard('recruiter-web')->user()->jobs()->create($request->all());

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job created successfully');
    }

    public function edit($id)
    {
        $job = Auth::guard('recruiter-web')->user()
            ->jobs()
            ->findOrFail($id);

        return view('recruiter.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'status' => 'required|in:open,closed',
        ]);

        $job = Auth::guard('recruiter-web')->user()
            ->jobs()
            ->findOrFail($id);

        $job->update($request->all());

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job updated successfully');
    }

    public function destroy($id)
    {
        $job = Auth::guard('recruiter-web')->user()
            ->jobs()
            ->findOrFail($id);

        $job->delete();

        return redirect()
            ->route('recruiter.jobs.index')
            ->with('success', 'Job deleted successfully');
    }
}
