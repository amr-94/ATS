<?php

namespace App\Repositories;

use App\Interfaces\CandidateRepositoryInterface;
use App\Models\Candidate;
use App\Resources\CandidateResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CandidateRepository implements CandidateRepositoryInterface
{
    use ApiResponse;

    protected $model;

    public function __construct(Candidate $candidate)
    {
        $this->model = $candidate;
    }

    public function index(Request $request)
    {
        try {
            $candidates = $this->model
                ->with(['applications', 'applications.job'])
                ->paginate($request->get('per_page', 10));

            return $this->successResponse(
                CandidateResource::collection($candidates),
                'Candidates retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $candidate = $this->model
                ->with(['applications', 'applications.job'])
                ->findOrFail($id);

            return $this->successResponse(
                new CandidateResource($candidate),
                'Candidate retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->notFoundResponse('Candidate not found');
        }
    }

    public function delete($id)
    {
        try {
            $this->model->findOrFail($id)->delete();
            return $this->successResponse(
                null,
                'Candidate deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}