<?php

namespace App\Repositories;

use App\Dto\DTO;
use App\Interfaces\DTOInterface;
use App\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected string $key;

    public function __construct(
        private null|\Predis\Client $predis = null
    )
    {
        $this->predis ??= service('predis');
    }

    abstract protected function mapToDTO(array $data): DTO;

    private function getNextId(): int|string
    {
        return $this->predis->incr("{$this->key}:id");
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id): array
    {
        return $this->predis->hgetall("{$this->key}:{$id}");
    }

    public function create(DTOInterface $DTO): DTOInterface
    {
        $id = $this->getNextId();

        $DTO->setId($id);

        $this->predis->hmset("{$this->key}:{$id}", $DTO->toArray());

        return $DTO;
    }

    public function update($id, DTOInterface $DTO): DTOInterface
    {
        $DTO->setId($id);

        $this->predis->hmset("{$this->key}:{$id}", $DTO->toArray());

        return $DTO;
    }

    public function delete($id): bool
    {
        return (bool) $this->predis->del("{$this->key}:{$id}");
    }

}