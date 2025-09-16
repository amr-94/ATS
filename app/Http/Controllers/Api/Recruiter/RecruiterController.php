<?php

namespace App\Http\Controllers\Api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRecruiterRequest;
use App\Interfaces\RecruiterRepositoryInterface;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    protected $recruiterRepository;

    public function __construct(RecruiterRepositoryInterface $recruiterRepository)
    {
        $this->recruiterRepository = $recruiterRepository;
    }

    public function index(Request $request)
    {
        return $this->recruiterRepository->index($request);
    }

    public function show($id)
    {
        return $this->recruiterRepository->show($id);
    }

    public function update(UpdateRecruiterRequest $request, $id)
    {
        return $this->recruiterRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->recruiterRepository->delete($id);
    }
}
