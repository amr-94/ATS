<?php

namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRecruiterRequest;
use App\Interfaces\RecruiterRepositoryInterface;
use App\Resources\RecruiterResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    use ApiResponse;

    protected $recruiterRepository;

    public function __construct(RecruiterRepositoryInterface $recruiterRepository)
    {
        $this->recruiterRepository = $recruiterRepository;
    }

    public function index(Request $request)
    {
        $recruiters = $this->recruiterRepository->index($request->get('per_page', 10));
        return $this->successResponse(
            RecruiterResource::collection($recruiters),
            'Recruiters retrieved successfully'
        );
    }

    public function show($id)
    {
        $recruiter = $this->recruiterRepository->show($id);
        return $this->successResponse(
            new RecruiterResource($recruiter),
            'Recruiter retrieved successfully'
        );
    }

    public function update(UpdateRecruiterRequest $request, $id)
    {
        $recruiter = $this->recruiterRepository->update($id, $request->validated());
        return $this->successResponse(
            new RecruiterResource($recruiter),
            'Recruiter updated successfully'
        );
    }

    public function destroy($id)
    {
        $this->recruiterRepository->delete($id);
        return $this->successResponse(null, 'Recruiter deleted successfully');
    }
}
