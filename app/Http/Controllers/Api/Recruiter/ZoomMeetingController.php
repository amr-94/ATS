<?php

namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\ZoomService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoomMeetingController extends Controller
{
    use ApiResponse;

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
                return $this->errorResponse('Candidate information not found', 404);
            }

            $meeting = $this->zoomService->createMeeting($application, $request->only([
                'start_time',
                'duration'
            ]));

            return $this->successResponse([
                'meeting' => $meeting,
            ], 'Meeting created successfully');
        } catch (\Exception $e) {
            Log::error('Meeting Creation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to create meeting: ' . $e->getMessage(), 500);
        }
    }
}
