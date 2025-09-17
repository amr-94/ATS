<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidateRequest;
use App\Resources\CandidateResource;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CandidateAuthController extends Controller
{
    public function register(StoreCandidateRequest $request)
    {
        $validated =  $request->validated();

        // Handle resume file upload
        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')
                ->store('Candidate', 'public');
        }
        $validated['password'] = Hash::make($request->password);

        $candidate = Candidate::create($validated);

        $token = $candidate->createToken('api-token')->plainTextToken;

        return response()->json([
            'candidate' => new CandidateResource($candidate),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $candidate = Candidate::where('email', $request->email)->first();

        if (!$candidate || !Hash::check($request->password, $candidate->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $candidate->createToken('api-token')->plainTextToken;

        return response()->json([
            'candidate' => new CandidateResource($candidate),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->candidate()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'candidate' => new CandidateResource($request->user())
        ]);
    }
}