@extends('layouts.candidate_layoute')

@section('content')
    <div class="container">
        <h2 class="mb-4">Available Jobs</h2>

        @if ($jobs->count() > 0)
            <div class="row">
                @foreach ($jobs as $job)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $job->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $job->recruiter->name }}</h6>

                                <p class="card-text">{{ Str::limit($job->description, 150) }}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info">{{ $job->location }}</span>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#applyModal{{ $job->id }}">
                                        Apply Now
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Apply Modal -->
                        <div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('candidate.jobs.apply', $job->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Apply for {{ $job->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="cover_letter" class="form-label">Cover Letter</label>
                                                <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter"
                                                    rows="5" required></textarea>
                                                @error('cover_letter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Submit Application</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $jobs->links() }}
        @else
            <div class="alert alert-info">No jobs available at the moment.</div>
        @endif
    </div>
@endsection
