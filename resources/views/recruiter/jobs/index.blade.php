@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Jobs</h2>
            <a href="{{ route('recruiter.jobs.create') }}" class="btn btn-primary">Post New Job</a>
        </div>

        @if ($jobs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Applications</th>
                            <th>Posted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->location }}</td>
                                <td>
                                    <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td>{{ $job->applications_count }}</td>
                                <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('recruiter.jobs.edit', $job->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>

                                    <form action="{{ route('recruiter.jobs.destroy', $job->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $jobs->links() }}
        @else
            <div class="alert alert-info">
                No jobs posted yet. <a href="{{ route('recruiter.jobs.create') }}">Post your first job</a>
            </div>
        @endif
    </div>
@endsection
