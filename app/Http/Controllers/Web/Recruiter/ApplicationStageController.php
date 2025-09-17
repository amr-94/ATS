<?php

namespace App\Http\Controllers\Web\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class ApplicationStageController extends Controller
{
    public function index()
    {
        $applications = Application::whereHas('job', function ($query) {
            $query->where('recruiter_id', Auth::guard('recruiter-web')->id());
        })
            ->with(['job', 'candidate'])
            ->latest()
            ->paginate(10);

        return view('recruiter.applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::whereHas('job', function ($query) {
            $query->where('recruiter_id', Auth::guard('recruiter-web')->id());
        })
            ->with(['job', 'candidate', 'stageTransitions'])
            ->findOrFail($id);

        return view('recruiter.applications.show', compact('application'));
    }

    public function updateStage(Request $request, $id)
    {
        $request->validate([
            'stage' => 'required|in:applied,phone_screen,interview,hired,rejected',
            'notes' => 'nullable|string'
        ]);

        $toStage = $request->stage;

        $application = Application::whereHas('job', function ($query) {
            $query->where('recruiter_id', Auth::guard('recruiter-web')->id());
        })->findOrFail($id);

        $currentStage = $application->current_stage;

        // if the application is already in the desired stage
        if ($currentStage === $toStage) {
            return back()->withErrors(['stage' => 'Application is already in this stage']);
        }


        // to prevent moving back to a previous stage
        $stageOrder = [
            'applied'      => 1,
            'phone_screen' => 2,
            'interview'    => 3,
            'hired'        => 4,
            'rejected'     => 5,
        ];

        if ($stageOrder[$toStage] < $stageOrder[$currentStage]) {
            return back()->withErrors(['stage' => 'Cannot move back to a previous stage']);
        }


        $application->stageTransitions()->create([
            'from_stage' => $currentStage,
            'to_stage'   => $toStage,
            'notes'      => $request->notes,
            'changed_by' => Auth::guard('recruiter-web')->id(),
        ]);

        $application->update([
            'current_stage' => $toStage
        ]);

        return redirect()
            ->back()
            ->with('success', 'Application stage updated successfully');
    }
}
