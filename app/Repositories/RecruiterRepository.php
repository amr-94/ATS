<?php

namespace App\Repositories;

use App\Interfaces\RecruiterRepositoryInterface;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Hash;

class RecruiterRepository implements RecruiterRepositoryInterface
{
    protected $model;

    public function __construct(Recruiter $recruiter)
    {
        $this->model = $recruiter;
    }

    public function index($perPage = 10)
    {
        return $this->model
            ->with('jobs')
            ->paginate($perPage);
    }

    public function show($id)
    {
        return $this->model
            ->with('jobs')
            ->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $recruiter = $this->model->findOrFail($id);

        if (isset($data['password'])) {
            if (!Hash::check($data['current_password'], $recruiter->password)) {
                throw new \Exception('Current password is incorrect', 422);
            }
            $data['password'] = Hash::make($data['password']);
            unset($data['current_password']);
        }

        $recruiter->update($data);

        return $recruiter;
    }

    public function delete($id)
    {
        $recruiter = $this->model->findOrFail($id);
        $recruiter->delete();

        return true;
    }
}
