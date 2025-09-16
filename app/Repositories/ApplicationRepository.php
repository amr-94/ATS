<?php

namespace App\Repositories;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Models\Application;
use App\Resources\ApplicationResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    use ApiResponse;

    protected $model;

    public function __construct(Application $application)
    {
        $this->model = $application;
    }

    public function index(Request $request)
    {
        try {
            $applications = $this->model->with(['job', 'candidate'])->get();
            return $this->successResponse(ApplicationResource::collection($applications), 'Applications retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $application = $this->model->with(['job', 'candidate'])->findOrFail($id);
            return $this->successResponse(new ApplicationResource($application));
        } catch (\Exception $e) {
            return $this->notFoundResponse('Application not found');
        }
    }

    public function create(array $data)
    {
        try {
            $application = $this->model->create($data);
            return $this->successResponse(new ApplicationResource($application), 'Application created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $application = $this->model->findOrFail($id);
            $application->update($data);
            return $this->successResponse(new ApplicationResource($application), 'Application updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->model->findOrFail($id)->delete();
            return $this->successResponse(null, 'Application deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function byJob($jobId)
    {
        try {
            $applications = $this->model->where('job_id', $jobId)->with(['job', 'candidate'])->get();
            return $this->successResponse(ApplicationResource::collection($applications));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    // public function updateStage($id, $toStage, $recruiterId, $notes)
    // {
    //     try {
    //         $application = $this->model->findOrFail($id);

    //         // Check if recruiter owns the job
    //         if ($application->job->recruiter_id != $recruiterId) {
    //             return $this->errorResponse('Unauthorized', 403);
    //         }

    //         // Check if trying to update to current stage
    //         if ($application->current_stage === $toStage) {
    //             return $this->errorResponse('Application is already in this stage', 422);
    //         }

    //         // Get the ordered stages list
    //         $stagesOrder = [
    //             'applied',
    //             'phone_screen',
    //             'interview',
    //             'hired',
    //             'rejected'
    //         ];

    //         // Get current stage index
    //         $currentStageIndex = array_search($application->current_stage, $stagesOrder);
    //         $toStageIndex = array_search($toStage, $stagesOrder);

    //         // Check if trying to move backwards
    //         if ($toStageIndex < $currentStageIndex) {
    //             return $this->errorResponse('Cannot move application to a previous stage', 422);
    //         }

    //         // Create stage transition record
    //         $application->stageTransitions()->create([
    //             'from_stage' => $application->current_stage,
    //             'to_stage' => $toStage,
    //             'notes' => $notes,
    //             'changed_by' => $recruiterId
    //         ]);

    //         $application->update([
    //             'current_stage' => $toStage
    //         ]);

    //         return $this->successResponse(
    //             new ApplicationResource($application),
    //             'Application stage updated successfully'
    //         );
    //     } catch (\Exception $e) {
    //         return $this->errorResponse($e->getMessage());
    //     }
    // }
    public function updateStage($id, $toStage, $recruiterId, $notes)
    {
        try {
            $application = $this->model->findOrFail($id);

            // Check if recruiter owns the job
            if ($application->job->recruiter_id != $recruiterId) {
                return $this->errorResponse('Unauthorized', 403);
            }

            // Check if trying to update to current stage
            if ($application->current_stage === $toStage) {
                return $this->errorResponse('Application is already in this stage', 422);
            }

            // Check if last transition was to this stage
            $lastTransition = $application->stageTransitions()
                ->latest()
                ->first();

            if ($lastTransition && $lastTransition->to_stage === $toStage) {
                return $this->errorResponse('Cannot transition to the same stage consecutively', 422);
            }

            // Create stage transition record
            $application->stageTransitions()->create([
                'from_stage' => $application->current_stage,
                'to_stage' => $toStage,
                'notes' => $notes,
                'changed_by' => $recruiterId
            ]);

            $application->update([
                'current_stage' => $toStage
            ]);

            return $this->successResponse(
                new ApplicationResource($application),
                'Application stage updated successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getByCandidateId($candidateId)
    {
        try {
            $applications = $this->model
                ->where('candidate_id', $candidateId)
                ->with(['job', 'job.recruiter'])
                ->get();

            return $this->successResponse(ApplicationResource::collection($applications));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
