@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .section {
        margin-bottom: 1.5rem;
    }

    .section-title {
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .cover-letter-box {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
    }

    .timeline {
        position: relative;
        padding: 1rem 0;
    }

    .timeline-item {
        padding: 1rem;
        border-left: 2px solid #dee2e6;
        margin-left: 1rem;
        margin-bottom: 1rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-content {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
    }

    .timeline-notes {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .zoom-meeting-form {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
    }
</style>
@endpush
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Application Details</h5>
                </div>
                <div class="card-body">
                    <!-- Job Information -->
                    <div class="section">
                        <h6 class="section-title"><i class="fas fa-briefcase me-2"></i>Job Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Title:</strong> {{ $application->job->title }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Location:</strong> {{ $application->job->location }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Candidate Information -->
                    <div class="section">
                        <h6 class="section-title"><i class="fas fa-user me-2"></i>Candidate Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $application->candidate->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $application->candidate->email }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Application Status -->
                    <div class="section">
                        <h6 class="section-title"><i class="fas fa-info-circle me-2"></i>Application Status</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Current Stage:</strong>
                                    <span class="badge bg-{{ $application->current_stage === 'hired' ? 'success' : ($application->current_stage === 'rejected' ? 'danger' : 'primary') }}">
                                        {{ ucfirst($application->current_stage) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Applied Date:</strong> {{ $application->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($application->cover_letter)
                    <hr>
                    <div class="section">
                        <h6 class="section-title"><i class="fas fa-envelope me-2"></i>Cover Letter</h6>
                        <div class="cover-letter-box">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                    @endif

                    <!-- Zoom Meeting Section -->
                    @if ($application->current_stage === 'interview')
                    <hr>
                    <div class="section">
                        <h6 class="section-title"><i class="fas fa-video me-2"></i>Schedule Interview</h6>
                        @if($application->zoomMeeting)
                        <div class="alert alert-info">
                            <h6>Scheduled Meeting</h6>
                            <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($application->zoomMeeting->start_time)->format('F j, Y g:i A') }}</p>
                            <p><strong>Duration:</strong> {{ $application->zoomMeeting->duration }} minutes</p>
                            <p><strong>Join URL:</strong> <a href="{{ $application->zoomMeeting->join_url }}" target="_blank">Click here to join</a></p>
                            <p><strong>Password:</strong> {{ $application->zoomMeeting->password }}</p>
                        </div>
                        @else
                        <form action="{{ route('zoom-meetings.store', $application->id) }}" method="POST" class="zoom-meeting-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Meeting Date & Time</label>
                                        <input type="datetime-local" name="start_time" id="start_time"
                                            class="form-control @error('start_time') is-invalid @enderror" required>
                                        @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Duration (minutes)</label>
                                        <select name="duration" id="duration"
                                            class="form-select @error('duration') is-invalid @enderror" required>
                                            <option value="30">30 minutes</option>
                                            <option value="45">45 minutes</option>
                                            <option value="60">1 hour</option>
                                            <option value="90">1.5 hours</option>
                                        </select>
                                        @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-video me-2"></i>Schedule Zoom Meeting
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stage History -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Stage History</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach ($application->stageTransitions as $transition)
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-info">
                                        {{ $transition->created_at->format('Y-m-d H:i') }}
                                    </span>
                                    <span>
                                        <strong>{{ ucfirst($transition->from_stage) }}</strong>
                                        <i class="fas fa-arrow-right mx-2"></i>
                                        <strong>{{ ucfirst($transition->to_stage) }}</strong>
                                    </span>
                                </div>
                                @if ($transition->notes)
                                <div class="timeline-notes mt-2">
                                    {{ $transition->notes }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Stage Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Stage</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('recruiter.applications.updateStage', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="stage" class="form-label">New Stage</label>
                            <select class="form-select @error('stage') is-invalid @enderror" id="stage" name="stage" required>
                                <option value="">Select Stage</option>
                                <option value="applied" {{ $application->current_stage === 'applied' ? 'selected' : '' }}>Applied</option>
                                <option value="phone_screen" {{ $application->current_stage === 'phone_screen' ? 'selected' : '' }}>Phone Screen</option>
                                <option value="interview" {{ $application->current_stage === 'interview' ? 'selected' : '' }}>Interview</option>
                                <option value="hired" {{ $application->current_stage === 'hired' ? 'selected' : '' }}>Hired</option>
                                <option value="rejected" {{ $application->current_stage === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('stage')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="3"></textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Stage
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection