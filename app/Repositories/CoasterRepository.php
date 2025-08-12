<?php

namespace App\Repositories;

use App\Dto\CoasterDTO;
use App\Dto\DTO;

class CoasterRepository extends Repository
{
    protected string $key = 'coaster';

    protected function mapToDTO(array $data): DTO
    {
        return new CoasterDTO(
            staffCount: $data['staff_count'],
            clientCount: $data['client_count'],
            routeLength: $data['route_length'],
            startAt: $data['start_at'],
            endAt: $data['end_at'],
            id: $data['id'],
        );
    }
}