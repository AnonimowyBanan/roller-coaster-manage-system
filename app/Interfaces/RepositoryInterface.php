<?php

namespace App\Interfaces;

use App\Dto\DTO;

interface RepositoryInterface
{
    public function all();
    public function find($id): DTOInterface|null;
    public function create(DTOInterface $DTO): DTOInterface;
    public function update($id, DTO $DTO): DTOInterface;
    public function delete($id): bool;
}