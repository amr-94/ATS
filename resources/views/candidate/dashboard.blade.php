@extends('layouts.candidate_layoute')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Welcome, {{ $candidate->name }}!</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Applications</h5>
                        <a href="{{ route('candidate.applications.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        @if ($applications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $application->job->title }}</td>
                                                <td>{{ $application->job->recruiter->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $application->current_stage === 'hired'
                                                            ? 'success'
                                                            : ($application->current_stage === 'rejected'
                                                                ? 'danger'
                                                                : 'primary') }}">
                                                        {{ ucfirst($application->current_stage) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0">No applications yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary">
                                Browse Jobs
                            </a>
                            <a href="{{ route('candidate.profile') }}" class="btn btn-info">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
