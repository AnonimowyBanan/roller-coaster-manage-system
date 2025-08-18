<?php

namespace App\Services;

use App\Dto\CoasterDTO;
use App\Interfaces\DTOInterface;
use App\Repositories\CoasterRepository;
use App\Repositories\WagonRepository;
use CodeIgniter\I18n\Time;

class CoasterService
{
    public const STAFF_COUNT = 1;

    private DTOInterface $coasterDTO;
    private readonly CoasterRepository $coasterRepository;
    private readonly WagonRepository $wagonRepository;
    public array $wagons;
    private int $wagonsInCoaster;
    private int $currentStaff;

    public function __construct(
        CoasterDTO|int $coaster,
    ) {
        $this->coasterRepository = new CoasterRepository();

        if (is_numeric($coaster)) {
            $this->coasterDTO = $this->coasterRepository->find($coaster);
        }

        $this->coasterDTO ??= $coaster;

        $this->wagonRepository = new WagonRepository();

        $this->wagons = $this->wagonRepository->getWagonsByCoasterId($this->coasterDTO->id);

        $this->wagonsInCoaster = count($this->wagons);
        $this->currentStaff = $this->wagonsInCoaster * WagonService::STAFF_COUNT + self::STAFF_COUNT;
    }

    public function data(): array
    {
        return [
            'opening_hours' => [
                'start' => $this->coasterDTO->startAt,
                'end' => $this->coasterDTO->endAt,
            ],
            'wagons' => [
                'max' => 0,
                'current' => $this->wagonsInCoaster
            ],
            'staff' => [
                'max' => $this->coasterDTO->staffCount,
                'current' => $this->currentStaff,
            ],
            'clients' => [
                'count' => $this->coasterDTO->clientCount,
            ]
        ];
    }

    public function info()
    {

    }

    public function problems(): array
    {
        $problems = [];

        if (Time::parse($this->coasterDTO->startAt) >= Time::parse($this->coasterDTO->endAt)) {
            $problems['opening_hours'] = '';
        }

        if ($this->wagonsInCoaster) {
            $problems['wagons'] = "Kolejka ma zbyt dużo przypisanych wagonów.";
        }



        return $problems;
    }
}