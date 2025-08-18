<?php

namespace App\Services;

use App\Interfaces\DTOInterface;
use App\Interfaces\ManageServiceInterface;
use App\Repositories\Repository;

abstract class ManageService implements ManageServiceInterface
{
    protected int $staffCount;
    public DTOInterface $DTO;

    public function __construct(
        DTOInterface|int $DTO,
        private readonly ?Repository $repository
    ) {
        if (is_numeric($DTO)) {
            $this->DTO = $this->repository->find($DTO);
        }

        $this->DTO ??= $DTO;
    }
}
