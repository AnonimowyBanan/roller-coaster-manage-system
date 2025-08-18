<?php

namespace App\Services;

use App\Dto\CoasterDTO;
use App\Interfaces\DTOInterface;
use App\Repositories\CoasterRepository;
use CodeIgniter\I18n\Time;

class CoasterService extends ManageService
{
    protected int $staffCount = 1;

    public function __construct(
        DTOInterface|int $coaster,
    ) {
        parent::__construct($coaster, new CoasterRepository());
    }

    public function workTime(): int
    {
        return Time::parse($this->DTO->startAt)->difference(Time::parse($this->DTO->endAt))->getSeconds();
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
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