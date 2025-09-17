<?php

namespace App\Http\Controllers\Web\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RecruiterController extends Controller
{
    public function dashboard()
    {
        $recruiter = Auth::guard('recruiter-web')->user();
        $jobsCount = $recruiter->jobs()->count();
        $activeJobsCount = $recruiter->jobs()->where('status', 'open')->count();

        // Get all applications from recruiter's jobs
        $applications = collect();
        foreach ($recruiter->jobs as $job) {
            $applications = $applications->concat($job->applications);
        }

        $recentApplications = $applications->sortByDesc('created_at')->take(5);

        return view('recruiter.dashboard', compact(
            'recruiter',
            'jobsCount',
            'activeJobsCount',
            'applications',
            'recentApplications'
        ));
    }

    public function profile()
    {
        $recruiter = Auth::guard('recruiter-web')->user();
        return view('recruiter.profile', compact('recruiter'));
    }

    public function updateProfile(Request $request)
    {
        $recruiter = Auth::guard('recruiter-web')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:recuiters,email,' . $recruiter->id,
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            if (!Hash::check($request->current_password, $recruiter->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            $data['password'] = Hash::make($request->password);
        }

        $recruiter->update($data);

        return back()->with('success', 'Profile updated successfully');
    }
}