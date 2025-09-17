<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\CandidateAuthController;
use App\Http\Controllers\Web\Auth\RecruiterAuthController;
use App\Http\Controllers\Web\Recruiter\JobController;
use App\Http\Controllers\Web\Recruiter\ApplicationStageController;
use App\Http\Controllers\Web\Candidate\ApplicationController;
use App\Http\Controllers\Web\Candidate\CandidateController;
use App\Http\Controllers\Web\Recruiter\RecruiterController;

Route::get('/', function () {
    return view('welcome');
});

// Recruiter Routes
Route::prefix('recruiter')->group(function () {
    // Guest routes
    Route::middleware('guest:recruiter-web')->group(function () {
        Route::get('/login', [RecruiterAuthController::class, 'showLogin'])->name('recruiter.login');
        Route::post('/login', [RecruiterAuthController::class, 'login'])->name('recruiter.login.submit');
        Route::get('/register', [RecruiterAuthController::class, 'showRegister'])->name('recruiter.register');
        Route::post('/register', [RecruiterAuthController::class, 'register'])->name('recruiter.register.submit');
    });

    // Protected Routes
    Route::middleware('auth:recruiter-web')->group(function () {
        Route::post('/logout', [RecruiterAuthController::class, 'logout'])->name('recruiter.logout');
        Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('recruiter.dashboard');
        Route::get('/profile', [RecruiterController::class, 'profile'])->name('recruiter.profile');
        Route::put('/profile', [RecruiterController::class, 'updateProfile'])->name('recruiter.profile.update');

        // Jobs Management
        Route::get('/jobs', [JobController::class, 'index'])->name('recruiter.jobs.index');
        Route::get('/jobs/create', [JobController::class, 'create'])->name('recruiter.jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('recruiter.jobs.store');
        Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('recruiter.jobs.edit');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('recruiter.jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('recruiter.jobs.destroy');

        // Applications Management
        Route::get('/applications', [ApplicationStageController::class, 'index'])->name('recruiter.applications.index');
        Route::get('/applications/{id}', [ApplicationStageController::class, 'show'])->name('recruiter.applications.show');
        Route::put('/applications/{id}/stage', [ApplicationStageController::class, 'updateStage'])->name('recruiter.applications.updateStage');
    });
});

// Candidate Routes
Route::prefix('candidate')->group(function () {
    // Guest routes
    Route::middleware('guest:candidate-web')->group(function () {
        Route::get('/login', [CandidateAuthController::class, 'showLogin'])->name('candidate.login');
        Route::post('/login', [CandidateAuthController::class, 'login'])->name('candidate.login.submit');
        Route::get('/register', [CandidateAuthController::class, 'showRegister'])->name('candidate.register');
        Route::post('/register', [CandidateAuthController::class, 'register'])->name('candidate.register.submit');
    });

    // Protected Routes
    Route::middleware('auth:candidate-web')->group(function () {
        Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('candidate.logout');
        Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
        Route::get('/profile', [CandidateController::class, 'profile'])->name('candidate.profile');
        Route::put('/profile/update', [CandidateController::class, 'updateProfile'])
            ->name('candidate.profile.update');

        // Jobs & Applications
        Route::get('/jobs', [ApplicationController::class, 'availableJobs'])->name('candidate.jobs.index');
        Route::get('/applications', [ApplicationController::class, 'myApplications'])->name('candidate.applications.index');
        Route::post('/jobs/{id}/apply', [ApplicationController::class, 'apply'])->name('candidate.jobs.apply');
    });
});