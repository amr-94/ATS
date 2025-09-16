<?php

namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStageRequest;
use App\Interfaces\ApplicationRepositoryInterface;

class ApplicationStageController extends Controller
{
    protected $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function update(UpdateStageRequest $request, $id)
    {
        $data = $request->validated();
        return $this->applicationRepository->updateStage(
            $id,
            $data['to_stage'],
            auth('recruiter')->id(),
            $data['notes'] ?? null
        );
    }
}
