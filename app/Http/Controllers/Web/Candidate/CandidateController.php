<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function dashboard()
    {
        $candidate = Auth::guard('candidate-web')->user();
        $applications = $candidate->applications()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();

        return view('candidate.dashboard', compact('candidate', 'applications'));
    }

    public function profile()
    {
        $candidate = Auth::guard('candidate-web')->user();
        return view('candidate.profile', compact('candidate'));
    }

    public function updateProfile(Request $request)
    {
        $candidate = Auth::guard('candidate-web')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone']);

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            if (!Hash::check($request->current_password, $candidate->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            $data['password'] = Hash::make($request->password);
        }


        if ($request->hasFile('resume')) {
            // if the candidate already has a resume, delete the old one
            if ($candidate->resume_path && Storage::disk('public')->exists($candidate->resume_path)) {
                Storage::disk('public')->delete($candidate->resume_path);
            }

            $data['resume_path'] = $request->file('resume')->store('candidates/resumes', 'public');
        }

        $candidate->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}