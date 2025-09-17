@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Applications Management</h2>

        @if ($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Candidate</th>
                            <th>Current Stage</th>
                            <th>Applied Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td>{{ $application->job->title }}</td>
                                <td>{{ $application->candidate->name }}</td>
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
                                <td>
                                    <a href="{{ route('recruiter.applications.show', $application->id) }}"
                                        class="btn btn-sm btn-info">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $applications->links() }}
        @else
            <div class="alert alert-info">No applications found.</div>
        @endif
    </div>
@endsection
