<?php

namespace App\Dto;

class WagonDTO extends DTO
{
    public function __construct(
        public readonly int $places,
        public readonly float $speed,
        public readonly ?int $coasterId = null,
    ) {}

    public function toArray(): array
    {
        return [
            ...(isset($this->id) ? ['id' => $this->id] : []),
            ...(isset($this->coasterId) ? ['coaster_id' => $this->coasterId] : []),
            'speed' => $this->speed,
            'places' => $this->places,
        ];
    }
}