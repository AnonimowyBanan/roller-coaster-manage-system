<?php

namespace App\Api\v1;

use App\Controllers\BaseController;
use App\Dto\CoasterDTO;
use App\Repositories\CoasterRepository;
use App\Repositories\Repository;
use CodeIgniter\API\ResponseTrait;

class Coaster extends BaseController
{
    use ResponseTrait;

    public function __construct(
        private null|Repository $coasterRepository = null,
        private $validation = null
    )
    {
        $this->coasterRepository ??= new CoasterRepository();
        $this->validation ??= service('validation');
    }

    public function store(): \CodeIgniter\HTTP\ResponseInterface
    {
        $this->validation->setRules([
            'liczba_personelu' => 'required|integer|greater_than[0]',
            'liczba_klientow' => 'required|integer|greater_than[0]',
            'dl_trasy' => 'required|integer|greater_than[0]',
            'godziny_od' => 'required|string',
            'godziny_do' => 'required|string',
        ]);

        if (! $this->validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        $validated = $this->validation->getValidated();

        $coasterDTO = new CoasterDTO(
            staffCount: $validated['liczba_personelu'],
            clientCount: $validated['liczba_klientow'],
            routeLength: $validated['dl_trasy'],
            startAt: $validated['godziny_od'],
            endAt: $validated['godziny_do']
        );

        $newCoaster = $this->coasterRepository->create($coasterDTO->toArray());

        return $this->respondCreated($newCoaster);
    }

    public function update(int $coasterId): \CodeIgniter\HTTP\ResponseInterface
    {
        $coasterData = $this->coasterRepository->find($coasterId);

        if (empty($coasterData)) {
            return $this->failNotFound('Coaster does not exist');
        }

        $this->validation->setRules([
            'liczba_personelu' => 'required|integer|greater_than[0]',
            'liczba_klientow' => 'required|integer|greater_than[0]',
            'godziny_od' => 'required|string',
            'godziny_do' => 'required|string',
        ]);

        if (! $this->validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        $validated = $this->validation->getValidated();

        $coasterData = $this->coasterRepository->find($coasterId);

        $coasterDTO = new CoasterDTO(
            staffCount: $validated['liczba_personelu'],
            clientCount: $validated['liczba_klientow'],
            routeLength: $coasterData['route_length'],
            startAt: $validated['godziny_od'],
            endAt: $validated['godziny_do']
        );

        $updatedCoaster = $this->coasterRepository->update($coasterId, $coasterDTO->toArray());

        return $this->respondUpdated($updatedCoaster);
    }
}