<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RecruiterRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function update($id, array $data);
    public function delete($id);
}
