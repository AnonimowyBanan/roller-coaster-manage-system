<?php

namespace App\Repositories;

use App\Dto\DTO;
use App\Interfaces\DTOInterface;
use App\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected string $key;

    public function __construct(
        protected null|\Predis\Client $redis = null
    )
    {
        $this->redis ??= service('predis');
    }

    abstract protected function mapToDTO(array $data): DTO;

    private function getNextId(): int|string
    {
        return $this->redis->incr("{$this->key}:id");
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id): DTOInterface|null
    {
        $data = $this->redis->hgetall("{$this->key}:{$id}");

        if (empty($data)) {
            return null;
        }

        $dto = $this->mapToDTO($data);

        $dto->setId($id);

        return $dto;
    }

    public function create(DTOInterface $DTO): DTOInterface
    {
        $id = $this->getNextId();

        $DTO->setId($id);

        $this->redis->hmset("{$this->key}:{$id}", $DTO->toArray());

        return $DTO;
    }

    public function update($id, DTOInterface $DTO): DTOInterface
    {
        $DTO->setId($id);

        $this->redis->hmset("{$this->key}:{$id}", $DTO->toArray());

        return $DTO;
    }

    public function delete($id): bool
    {
        return (bool) $this->redis->del("{$this->key}:{$id}");
    }

}