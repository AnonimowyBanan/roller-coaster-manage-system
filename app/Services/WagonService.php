<?php

namespace App\Services;

use App\Dto\CoasterDTO;
use App\Dto\WagonDTO;
use App\Interfaces\DTOInterface;
use App\Repositories\CoasterRepository;
use App\Repositories\WagonRepository;

class WagonService extends ManageService
{
    protected int $staffCount = 2;
    protected int $breakBetweenRoutes = 5 * 60;
    protected ?CoasterService $coasterService;

    public function __construct(
        DTOInterface|int $wagon,
    ) {
        parent::__construct($wagon, new WagonRepository());

        $this->coasterService = new CoasterService((new CoasterRepository())->find($this->DTO->coasterId));
    }

    private function calculateTime(): float
    {
        return $this->coasterService->DTO->routeLength / $this->DTO->speed;
    }

    public function toArray(): array
    {
        $durationTime = $this->calculateTime();

        return [
            'places' => $this->DTO->places,
            'trace' => [
                'speed' => $this->DTO->speed,
                'duration' => $durationTime,
                'duration_with_break' => $durationTime + $this->breakBetweenRoutes,
                'routes' => floor($this->coasterService->workTime() / $durationTime),
            ]
        ];
    }

    public function info(): array
    {
        // TODO: Implement info() method.
    }

    public function problems(): array
    {
        // TODO: Implement problems() method.
    }
}