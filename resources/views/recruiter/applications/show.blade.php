@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Application Details</h5>
                    </div>
                    <div class="card-body">
                        <h6>Job Information</h6>
                        <p><strong>Title:</strong> {{ $application->job->title }}</p>
                        <p><strong>Location:</strong> {{ $application->job->location }}</p>

                        <hr>

                        <h6>Candidate Information</h6>
                        <p><strong>Name:</strong> {{ $application->candidate->name }}</p>
                        <p><strong>Email:</strong> {{ $application->candidate->email }}</p>

                        <hr>

                        <h6>Application Information</h6>
                        <p><strong>Current Stage:</strong>
                            <span
                                class="badge bg-{{ $application->current_stage === 'hired'
                                    ? 'success'
                                    : ($application->current_stage === 'rejected'
                                        ? 'danger'
                                        : 'primary') }}">
                                {{ ucfirst($application->current_stage) }}
                            </span>
                        </p>
                        <p><strong>Applied Date:</strong> {{ $application->created_at->format('Y-m-d') }}</p>

                        @if ($application->cover_letter)
                            <hr>
                            <h6>Cover Letter</h6>
                            <p>{{ $application->cover_letter }}</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Stage History</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($application->stageTransitions as $transition)
                                <div class="mb-3">
                                    <p class="mb-1">
                                        <strong>{{ ucfirst($transition->from_stage) }}</strong> →
                                        <strong>{{ ucfirst($transition->to_stage) }}</strong>
                                    </p>
                                    <p class="mb-1"><small>{{ $transition->created_at->format('Y-m-d H:i') }}</small></p>
                                    @if ($transition->notes)
                                        <p class="mb-0">Notes: {{ $transition->notes }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Update Stage</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('recruiter.applications.updateStage', $application->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="stage" class="form-label">New Stage</label>
                                <select class="form-select @error('stage') is-invalid @enderror" id="stage"
                                    name="stage" required>
                                    <option value="">Select Stage</option>
                                    <option value="applied">Applied</option>
                                    <option value="phone_screen">Phone Screen</option>
                                    <option value="interview">Interview</option>
                                    <option value="hired">Hired</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                @error('stage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"></textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Stage</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
