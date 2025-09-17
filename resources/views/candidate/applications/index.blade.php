@extends('layouts.candidate_layoute')

@section('content')
    <div class="container">
        <h2 class="mb-4">My Applications</h2>

        @if ($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Last Updated</th>
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
                                <td>{{ $application->updated_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $applications->links() }}
        @else
            <div class="alert alert-info">
                You haven't applied to any jobs yet.
                <a href="{{ route('candidate.jobs.index') }}" class="alert-link">Browse available jobs</a>
            </div>
        @endif
    </div>
@endsection
