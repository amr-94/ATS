<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CandidateAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:candidate-web')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.candidate.login');
    }

    public function showRegister()
    {
        return view('auth.candidate.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('candidate-web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('candidate.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:candidates',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $candidate = Candidate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::guard('candidate-web')->login($candidate);
        $request->session()->regenerate();

        return redirect()->route('candidate.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('candidate-web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('candidate.login');
    }
}
