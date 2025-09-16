<?php

use App\Http\Controllers\Api\Auth\CandidateAuthController;
use App\Http\Controllers\Api\Auth\RecruiterAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Recruiter\JobController;
use App\Http\Controllers\Api\Recruiter\ApplicationStageController;
use App\Http\Controllers\Api\Candidate\ApplicationController;
use App\Http\Controllers\Api\Candidate\CandidateController;
use App\Http\Controllers\Api\Recruiter\RecruiterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('v1')->group(
    function () {


        // ================= Auth Routes =================
        // Recruiter Auth
        Route::prefix('recruiter/auth')->group(function () {
            Route::post('register', [RecruiterAuthController::class, 'register']);
            Route::post('login', [RecruiterAuthController::class, 'login']);
            Route::post('logout', [RecruiterAuthController::class, 'logout'])->middleware('auth:recruiter');
            Route::get('profile', [RecruiterAuthController::class, 'profile'])->middleware('auth:recruiter');
        });

        // Candidate Auth
        Route::prefix('candidate/auth')->group(function () {
            Route::post('register', [CandidateAuthController::class, 'register']);
            Route::post('login', [CandidateAuthController::class, 'login']);
            Route::post('logout', [CandidateAuthController::class, 'logout'])->middleware('auth:candidate');
            Route::get('profile', [CandidateAuthController::class, 'profile'])->middleware('auth:candidate');
        });

        // ================= Recruiter Routes =================
        Route::prefix('recruiter')->middleware(['auth:recruiter'])->group(function () {
            // Recruiter Management
            Route::get('/', [RecruiterController::class, 'index']);
            Route::get('/{id}', [RecruiterController::class, 'show']);
            Route::put('/{id}', [RecruiterController::class, 'update']);
            Route::delete('/{id}', [RecruiterController::class, 'destroy']);

            // Jobs CRUD
            Route::get('jobs', [JobController::class, 'index']);
            Route::post('jobs', [JobController::class, 'store']);
            Route::put('jobs/{id}', [JobController::class, 'update']);
            Route::delete('jobs/{id}', [JobController::class, 'destroy']);
            // Candidate Management
            Route::get('candidate', [CandidateController::class, 'index']);
            Route::get('candidate/{id}', [CandidateController::class, 'show']);
            Route::delete('candidate/{id}', [CandidateController::class, 'destroy']);


            // Application Stage Update
            Route::put('applications/{id}/stage', [ApplicationStageController::class, 'update']);
        });

        // ================= Candidate Routes =================
        Route::prefix('candidate')->middleware(['auth:candidate'])->group(function () {
            // Apply to Job
            Route::post('jobs/{job}/apply', [ApplicationController::class, 'apply']);
            // View My Applications
            Route::get('/applications', [ApplicationController::class, 'myApplications']);
        });
    }
);
