<?php

namespace App\Repositories;

use App\Dto\DTO;
use App\Dto\WagonDTO;

class WagonRepository extends Repository
{
    protected string $key = 'wagon';

    protected function mapToDTO(array $data): DTO
    {
        return new WagonDTO(
            places: $data['places'],
            speed: $data['speed'],
            coasterId: $data['coaster_id'] ?? null,
        );
    }
}