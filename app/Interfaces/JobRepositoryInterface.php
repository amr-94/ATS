<?php

namespace App\Interfaces;

interface JobRepositoryInterface
{
    public function index();
    public function show($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
