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
                            <th>Interview</th>
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
                                <td>
                                    @if ($application->current_stage === 'interview' && $application->zoomMeeting)
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $meetingTime = \Carbon\Carbon::parse($application->zoomMeeting->start_time);
                                            $endTime = $meetingTime
                                                ->copy()
                                                ->addMinutes($application->zoomMeeting->duration);
                                            $joinTime = $meetingTime->copy()->subMinutes(15);
                                            $gracePeriodEnd = $meetingTime->copy()->addMinutes(5); // 5 minutes grace period
                                        @endphp

                                        @switch(true)
                                            {{-- داخل وقت الدخول --}}
                                            @case($now->between($joinTime, $gracePeriodEnd))
                                                <div>
                                                    <a href="{{ $application->zoomMeeting->join_url }}" target="_blank"
                                                        class="btn btn-success btn-sm mb-2">
                                                        <i class="fas fa-video"></i> Join Interview Now
                                                    </a>
                                                    <small class="d-block text-muted">
                                                        @if ($now->gt($endTime))
                                                            <span class="text-danger">Meeting ended but you can still join for
                                                                {{ $now->diffInMinutes($gracePeriodEnd) }} more minutes</span>
                                                        @else
                                                            Meeting ends at {{ $endTime->format('h:i A') }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @break

                                            {{-- لسه قبل الميتنج --}}
                                            @case($now->lt($meetingTime))
                                                @php
                                                    $minutesToJoin = $now->diffInMinutes($joinTime, false);
                                                    $diffString = $meetingTime->diffForHumans($now, [
                                                        'parts' => 2,
                                                        'short' => true,
                                                        'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                                                    ]);
                                                @endphp
                                                <div class="text-muted">
                                                    <span class="d-block mb-1">Interview in {{ $diffString }}</span>
                                                    @if ($minutesToJoin > 0 && $minutesToJoin <= 60)
                                                        <small class="d-block text-success">
                                                            Join link will appear in {{ $minutesToJoin }}
                                                            {{ Str::plural('minute', $minutesToJoin) }}
                                                        </small>
                                                    @endif
                                                    <small class="d-block text-muted">
                                                        ({{ $meetingTime->format('d M Y, h:i A') }})
                                                    </small>
                                                </div>
                                            @break

                                            {{-- الميتنج خلص --}}

                                            @default
                                                <div>
                                                    <span class="badge bg-secondary">Interview Ended</span>
                                                    <small class="d-block text-muted mt-1">Meeting has ended</small>
                                                </div>
                                        @endswitch
                                    @else
                                        <span class="text-muted">No Meeting Scheduled</span>
                                    @endif
                                </td>


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
