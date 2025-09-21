<?php

namespace App\Http\Controllers\Web\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoomMeetingController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function createMeeting(Request $request, Application $application)
    {
        try {
            $request->validate([
                'start_time' => 'required|date|after:now',
                'duration' => 'required|integer|min:15|max:180'
            ]);

            $application->load(['candidate']);

            if (!$application->candidate) {
                return back()->with('error', 'Candidate information not found');
            }

            $this->zoomService->createMeeting($application, $request->only([
                'start_time',
                'duration'
            ]));

            return back()->with('success', 'Meeting scheduled successfully');
        } catch (\Exception $e) {
            Log::error('Meeting Creation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to create meeting: ' . $e->getMessage());
        }
    }
}
