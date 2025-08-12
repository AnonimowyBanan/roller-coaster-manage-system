<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function all();
    public function find($id): array;
    public function create(array $attributes): array;
    public function update($id, array $attributes): array;
    public function delete($id);
}