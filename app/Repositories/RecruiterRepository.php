<?php

namespace App\Repositories;

use App\Interfaces\RecruiterRepositoryInterface;
use App\Models\Recruiter;
use App\Resources\RecruiterResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RecruiterRepository implements RecruiterRepositoryInterface
{
    use ApiResponse;

    protected $model;

    public function __construct(Recruiter $recruiter)
    {
        $this->model = $recruiter;
    }

    public function index(Request $request)
    {
        try {
            $recruiters = $this->model
                ->with('jobs')
                ->paginate($request->get('per_page', 10));

            return $this->successResponse(
                RecruiterResource::collection($recruiters),
                'Recruiters retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $recruiter = $this->model
                ->with('jobs')
                ->findOrFail($id);

            return $this->successResponse(
                new RecruiterResource($recruiter),
                'Recruiter retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->notFoundResponse('Recruiter not found');
        }
    }

    public function update($id, array $data)
    {
        try {
            $recruiter = $this->model->findOrFail($id);

            // Handle password update if provided
            if (isset($data['password'])) {
                if (!Hash::check($data['current_password'], $recruiter->password)) {
                    return $this->errorResponse('Current password is incorrect', 422);
                }
                $data['password'] = Hash::make($data['password']);
                unset($data['current_password']);
            }

            $recruiter->update($data);

            return $this->successResponse(
                new RecruiterResource($recruiter),
                'Recruiter updated successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function delete($id)
    {
        try {
            $recruiter = $this->model->findOrFail($id);
            $recruiter->delete();

            return $this->successResponse(
                null,
                'Recruiter deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
