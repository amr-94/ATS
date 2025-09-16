<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CandidateRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function delete($id);
}
