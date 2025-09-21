<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Application;
use App\Models\ZoomMeeting;

class ZoomService
{
    public function generateToken()
    {
        $clientId = config('zoom.client_id');
        $clientSecret = config('zoom.client_secret');
        $accountId = config('zoom.account_id');

        $base64 = base64_encode($clientId . ':' . $clientSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $base64,
        ])->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => $accountId,
        ]);

        if (!$response->successful()) {
            Log::error('Zoom Token Error', ['body' => $response->json()]);
            throw new \Exception('Failed to generate Zoom access token');
        }

        return $response->json()['access_token'];
    }

    public function createMeeting(Application $application, array $meetingData)
    {
        $token = $this->generateToken();

        $zoomRequest = [
            'topic' => "Interview for " . $application->candidate->name,
            'type' => 2, // Scheduled meeting
            'start_time' => $meetingData['start_time'],
            'duration' => $meetingData['duration'],
            'password' => Str::random(10),
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => false,
                'waiting_room' => true,
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('https://api.zoom.us/v2/users/me/meetings', $zoomRequest);

        if (!$response->successful()) {
            Log::error('Zoom API Error', [
                'status' => $response->status(),
                'body' => $response->json(),
                'request' => $zoomRequest
            ]);
            throw new \Exception('Failed to create zoom meeting: ' .
                ($response->json()['message'] ?? 'Unknown error'));
        }

        $responseData = $response->json();
        $startTime = Carbon::parse($responseData['start_time'])->format('Y-m-d H:i:s');

        return ZoomMeeting::create([
            'application_id' => $application->id,
            'meeting_id' => $responseData['id'],
            'topic' => $responseData['topic'],
            'start_time' =>  $startTime,
            'duration' => $responseData['duration'],
            'join_url' => $responseData['join_url'],
            'password' => $responseData['password'],
        ]);
    }
}
