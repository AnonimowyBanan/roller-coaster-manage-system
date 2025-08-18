<?php

namespace App\Dto;

use App\Interfaces\DTOInterface;

abstract class DTO implements DTOInterface
{
    public int|string $id;

    public function getId(): int|string
    {
        return $this->id;
    }

    public function setId(int|string $id): void
    {
        $this->id = $id;
    }
}