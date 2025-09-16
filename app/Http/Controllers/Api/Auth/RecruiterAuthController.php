<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Resources\RecruiterResource;
use Illuminate\Http\Request;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RecruiterAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:recuiters',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $Recruiter = Recruiter::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $Recruiter->createToken('api-token')->plainTextToken;

        return response()->json([
            'Recruiter' => new RecruiterResource($Recruiter),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the recruiter first
        $recruiter = Recruiter::where('email', $request->email)->first();

        if (!$recruiter || !Hash::check($request->password, $recruiter->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $recruiter->createToken('api-token')->plainTextToken;

        return response()->json([
            'recruiter' => new RecruiterResource($recruiter),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function refresh(Request $request)
    {
        $Recruiter = $request->Recruiter();

        // Revoke the current token
        $request->Recruiter()->currentAccessToken()->delete();

        // Create a new token
        $newToken = $Recruiter->createToken('api-token')->plainTextToken;

        return response()->json([
            'Recruiter' => $Recruiter,
            'token' => $newToken,
        ]);
    }
    public function profile(Request $request)
    {
        return response()->json([
            'recruiter' => new RecruiterResource($request->user())
        ]);
    }
}
