<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Models\Recruiter;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RecruiterAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:recruiter-web')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.recruiter.login');
    }

    public function showRegister()
    {
        return view('auth.recruiter.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Change guard to recruiter-web
        if (Auth::guard('recruiter-web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('recruiter.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:recuiters',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $recruiter = Recruiter::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Change guard to recruiter-web
        Auth::guard('recruiter-web')->login($recruiter);
        $request->session()->regenerate();

        return redirect()->route('recruiter.dashboard');
    }

    public function logout(Request $request)
    {
        // Change guard to recruiter-web
        Auth::guard('recruiter-web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('recruiter.login');
    }
}
