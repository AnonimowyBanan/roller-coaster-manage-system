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

    public function getWagonsByCoasterId(?int $coasterId): array
    {
        $wagons = [];
        foreach ($this->redis->keys($this->key . ':*') as $key) {
            $wagon = $this->find((int) explode(':', $key)[1]);

            if (isset($wagon->coasterId) && $wagon->coasterId === $coasterId) {
                $wagons[$wagon->id] = $wagon;
            }
        }

        return $wagons;
    }
}