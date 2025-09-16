<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ApplicationRepositoryInterface
{
    public function index(Request $request);

    public function show($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function byJob($jobId);
    public function getByCandidateId($candidateId);
    public function updateStage($id, $toStage, $recruiterId, $notes);
}
