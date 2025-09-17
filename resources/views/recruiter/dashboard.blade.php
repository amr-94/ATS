@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Welcome, {{ $recruiter->name }}!</h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Jobs</h5>
                        <h2 class="card-text">{{ $jobsCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active Jobs</h5>
                        <h2 class="card-text">{{ $activeJobsCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Applications</h5>
                        <h2 class="card-text">{{ $applications->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Applications</h5>
                        <a href="{{ route('recruiter.applications.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        @if ($recentApplications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Candidate</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentApplications as $application)
                                            <tr>
                                                <td>{{ $application->job->title }}</td>
                                                <td>{{ $application->candidate->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $application->current_stage === 'hired' ? 'success' : 'primary' }}">
                                                        {{ ucfirst($application->current_stage) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('recruiter.applications.show', $application->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0">No recent applications.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('recruiter.jobs.create') }}" class="btn btn-primary">
                                Post New Job
                            </a>
                            <a href="{{ route('recruiter.jobs.index') }}" class="btn btn-secondary">
                                Manage Jobs
                            </a>
                            <a href="{{ route('recruiter.profile') }}" class="btn btn-info">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
