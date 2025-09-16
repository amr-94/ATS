<?php

namespace App\Http\Controllers\Api\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateRequest;
use App\Interfaces\CandidateRepositoryInterface;
use App\Resources\CandidateResource;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    protected $candidateRepository;

    public function __construct(CandidateRepositoryInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function index(Request $request)
    {
        return $this->candidateRepository->index($request);
    }

    public function show($id)
    {
        return $this->candidateRepository->show($id);
    }

    public function destroy($id)
    {
        return $this->candidateRepository->delete($id);
    }
}
