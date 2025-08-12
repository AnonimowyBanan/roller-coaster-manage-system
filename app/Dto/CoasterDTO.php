<?php

namespace App\Dto;

class CoasterDTO extends DTO
{
    public function __construct(
        public readonly int $staffCount,
        public readonly int $clientCount,
        public readonly int $routeLength,
        public readonly string $startAt,
        public readonly string $endAt,
    ) {}


    public function toArray(): array
    {
        return [
            ...(isset($this->id) ? ['id' => $this->id] : []),
            'staff_count'  => $this->staffCount,
            'client_count' => $this->clientCount,
            'route_length' => $this->routeLength,
            'start_at'     => $this->startAt,
            'end_at'       => $this->endAt,
        ];
    }
}