<?php

namespace App\Api\v1;

use App\Controllers\BaseController;
use App\Dto\WagonDTO;
use App\Repositories\CoasterRepository;
use App\Repositories\Repository;
use App\Repositories\WagonRepository;
use CodeIgniter\API\ResponseTrait;

class Wagon extends BaseController
{
    use ResponseTrait;

    public function __construct(
        private null|Repository $wagonRepository = null,
        private $validation = null
    )
    {
        $this->wagonRepository ??= new WagonRepository();
        $this->validation ??= service('validation');
    }

    public function store(int $coasterId): \CodeIgniter\HTTP\ResponseInterface
    {
        $this->validation->setRules([
            'ilosc_miejsc' => 'required|integer|greater_than[0]',
            'predkosc_wagonu' => 'required|numeric|greater_than[0]',
        ]);

        if (! $this->validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        $validated = $this->validation->getValidated();

        $wagonDTO = new WagonDTO(
            places: $validated['ilosc_miejsc'],
            speed: $validated['predkosc_wagonu'],
            coasterId: $coasterId
        );

        $newWagon = $this->wagonRepository->create($wagonDTO->toArray());

        return $this->respondCreated($newWagon);
    }

    public function destroy(int $coasterId, int $wagonId): \CodeIgniter\HTTP\ResponseInterface
    {
        if ($this->wagonRepository->delete($wagonId)) {
            return $this->respondDeleted([
                'message' => 'Wagon deleted successfully'
            ]);
        }

        return $this->fail('Wagon not deleted');
    }
}